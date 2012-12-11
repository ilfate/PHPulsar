<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

/**
 * CacheingClass class 
 *
 * @author ilfate
 */
abstract class CoreCachingClass
{
  
  const TAGS_PARAM_DELIMITER = '__p__';
  const TAGS_DELIMITER       = '__t__';
  const CLASS_DELIMITER      = '__c__';
  
  
  private static $meta;
  
  public static $forceNoCache = false;
  
  
  /**
   * Here we get cache key based on class and methods names
   *
   * @param string $method method name
   * @param array $parameters Params in the same order
   * @return string
   */
  public static function getCacheKey($method, $parameters) {
    $class = get_called_class();
    if (empty($parameters)) {
      return $class . self::CLASS_DELIMITER . $method;
    } else {
      return $class . self::CLASS_DELIMITER . $method . "__" . md5(str_replace("\"", "", json_encode($parameters)));
    }
  }

  /**
   * Returns caching tag for paticular class
   *
   * @param string $tag tag name
   * @return string
   */
  public static function getCacheTag($tag, $parameters = array()) 
  {
    $class = get_called_class();
    if(strpos($tag, '[') !== false)
    {
      $maches = array();
    // search for params like [0] [1] [2] ect...
      preg_match_all('#\[(\d+)\]#', $tag, $maches);
    
      if(sizeof($maches) > 0)
      {
        $param_arr = $maches[1];
        $tag = strstr($tag, '[', true) . self::TAGS_PARAM_DELIMITER;
        foreach ($param_arr as $param_num)
        {
          if(!isset($parameters[$param_num]))
          {
            throw new CoreException_CacheError('Error during caching Tag with param. Param '. $param_num . ' is mising');
          }
          $tag .= '_' . $parameters[$param_num];
        }
      }
    }
    return $class . self::TAGS_DELIMITER . $tag;
  }

  /**
   * What we doing here? We saying that every class that extends from this one
   * can cache in methods. 
   * To cache myMethod you need to create _myMethod in that class instead.
   * To that method you need apply @cache phpDoc comment.
   * If you write "@cache 30" that method will be cached for 30 seconds
   * if you write "@cache 60 myTag" method will be cached with "myTag" tag.
   * 
   */
  public static function __callStatic($method, $arguments = array()) 
  {
    $class = get_called_class();
    $callMethod = "_" . $method;
    $metaKey = self::getMetaKeyMethod($method, true);
    
    // If if have correct params we starting to looking for cache
    if (!empty(self::$meta[$metaKey]) && self::$meta[$metaKey]["cache"]) 
    {
      $cacheKey = self::getCacheKey($method, $arguments);
      if (static::$forceNoCache || ($result = Cache::get($cacheKey)) === false)  
      {
        $result = forward_static_call_array(array($class, $callMethod), $arguments);
        $tags = null;
        if (!empty(self::$meta[$metaKey]["tags"])) 
        {
        // set up tags, if they are exists
          $tags = array();
          foreach (self::$meta[$metaKey]["tags"] as $tag) 
          {
            $tags[] = self::getCacheTag($tag, $arguments);
          }
        }
        Cache::set($cacheKey, ($result === false) ? "\0" : $result, self::$meta[$metaKey]["expire"], $tags);
      } elseif ($result === "\0") {
        $result = false;
      }
    } else {
      $result = forward_static_call_array(array($class, $callMethod), $arguments);
    }
    static::$forceNoCache = false;
    return $result;
  }
  
  
  public function __call($method, $arguments = array()) 
  {
    $callMethod = "_" . $method;
    $metaKey = self::getMetaKeyMethod($method, false);
    
    // If if have correct params we starting to looking for cache
    if (!empty(self::$meta[$metaKey]) && self::$meta[$metaKey]["cache"]) 
    {
      $cacheKey = self::getCacheKey($method, $arguments);
      if (static::$forceNoCache || ($result = Cache::get($cacheKey)) === false) 
      {
        $result = call_user_func_array(array($this, $callMethod), $arguments);
        $tags = null;
        if (!empty(self::$meta[$metaKey]["tags"])) 
        {
      // set up tags, if they are exists
          $tags = array();
          foreach (self::$meta[$metaKey]["tags"] as $tag) 
          {
            $tags[] = self::getCacheTag($tag, $arguments);
          }
        }
        Cache::set($cacheKey, ($result === false) ? "\0" : $result, self::$meta[$metaKey]["expire"], $tags);
      } elseif ($result === "\0") {
        $result = false;
      }
    } else {
      $result = call_user_func_array(array($this, $callMethod), $arguments);
    }
    static::$forceNoCache = false;
    return $result;
  }
  
  protected static function getMetaKeyMethod($method, $is_static)
  {
    $class = get_called_class();
    $callMethod = "_" . $method;
    if (!method_exists($class, $callMethod)) 
    {
      throw new CoreException_Error("Method " . $class . ($is_static?"::":"->") . $method . "() does not exist");
    }
    $metaKey = $class . ($is_static?"::":"->") . $callMethod;
    if (!isset(self::$meta[$metaKey])) 
    {
      $meta = new ReflectionMethod($class, $callMethod);
      $comment = $meta->getDocComment();
      $params = array();
      $matches = array();
      if (!empty($comment)) // If there is phpDoc search it for comments that we need
      { 
        preg_match("/@cache([ \t]+(\d+)){0,1}([ \t]+([\w \t\[\]]+[\w\]])){0,1}/", $comment, $matches);
        if (!empty($matches)) 
        {
          $params["cache"] = true;
          $params["expire"] = !empty($matches[2]) ? (int) $matches[2] : 0;
          $params["tags"] = !empty($matches[4]) ? preg_split("/[ \t]+/", $matches[4]) : array();
        }
      }
      self::$meta[$metaKey] = $params;
    }
    return $metaKey;
  }
 
}

?>
