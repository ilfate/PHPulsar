<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

/**
 * Request class 
 *
 * @author ilfate
 */
class CoreRequest implements CoreInterfaceRequest {
  
  private static $post;
  private static $get;
  private static $save;
  
  
  const EXECUTE_MODE_HTTP = 'http';
  const EXECUTE_MODE_AJAX = 'ajax';
  const EXECUTE_MODE_HTTP_AJAX = 'http_ajax';
  const EXECUTE_MODE_HTTP_SUBQUERY = 'subquery';
  const EXECUTE_MODE_CLI = 'cli';
  
  const PARAM_AJAX      = '__ajax';
  const PARAM_AJAX_HTML = '__html';

  private static $executingMode;
  
  public function __construct() 
  {
    $escape_function = function(&$item, $key) {
      $item = htmlentities($item);
      //$item = mysql_real_escape_string($item);
    
    };
    
    self::$get = $_GET;
    self::$post = $_POST;
       
    if(self::$post) 
    {
      array_walk_recursive(self::$post, $escape_function);
    }
    if(self::$get) 
    {
      array_walk_recursive(self::$get, $escape_function);
    }
  }
  
  /**
   * return array with POST like $_POST
   * 
   * @return Array
   */
  public static function getPost($param = null) 
  {
	if(!$param)
	{
      return self::$post;
	} elseif(isset(self::$post[$param])) {
	  return self::$post[$param];
	} else {
      return null;
	}
  }
  
  /**
   * return array with GET like $_GET
   * 
   * @return Array
   */
  public static function getGet($param = null) 
  {
    if($param)
    {
      if(isset(self::$get[$param]))
      {
        return self::$get[$param];
      } else {
        return null;
      }
    } else {
      return self::$get;
    }
  }
  
  /**
   * Returns method
   */
  public static function getMethod()
  {
    return $_SERVER['REQUEST_METHOD'];  
  }
  
  /**
   * Save current request and sets new fake params
   * @param type $get
   * @param type $post 
   */
  public function setFakeRequest($get, $post)
  {
    $data = array('get' => self::$get, 'post' => $post, 'mode' => $this->getExecutingMode());
    if(!self::$save)
    {
      self::$save = array($data);
    } else {
      self::$save[] = $data;
    }
    self::$get = $get;
    self::$post = $post;
    self::$executingMode = self::EXECUTE_MODE_HTTP_SUBQUERY;
  }
  
  public function restoreRequest()
  {
    if(self::$save)
    {
      $data = array_pop(self::$save);
      self::$get = $data['get'];
      self::$post = $data['post'];
      self::$executingMode = $data['mode'];
    }
  }
  
  /**
   * return one of the possible executing modes.
   * 
   * @return string
   */
  public static function getExecutingMode() 
  {
    if(!self::$executingMode) 
    {
      if(isset(self::$get[self::PARAM_AJAX]) && isset(self::$get[self::PARAM_AJAX_HTML]))
      {
        self::$executingMode = self::EXECUTE_MODE_HTTP_AJAX;
	  } elseif(isset(self::$get[self::PARAM_AJAX]) && !isset(self::$get[self::PARAM_AJAX_HTML])) {
		  
        self::$executingMode = self::EXECUTE_MODE_AJAX;
		
      } else {
        // if no mode setted, let it be HTTP
        self::$executingMode = self::EXECUTE_MODE_HTTP;
      }
    }
    return self::$executingMode;
  }
  
  
  /**
   * Get user IP
   *
   * @return string
   */
  public static function getRemoteAddress() 
  {
    return (isset($_SERVER["HTTP_X_FORWARDED_FOR"]) && !empty($_SERVER["HTTP_X_FORWARDED_FOR"])) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"];
  }
  
  /**
   * Get URI of the request (without server adress)
   *
   * @return string
   */
  public static function getUri() 
  {
    if(isset($_SERVER["REQUEST_URI"])) 
    {
      $uri = parse_url($_SERVER["REQUEST_URI"]);
      return ($uri["path"] == "/" ? $uri["path"] : rtrim($uri["path"], "/")) . (isset($uri["query"]) ? "?" . $uri["query"] : "");
    } else {
      return "";
    }
  }
  /**
   * Get URI of the request (without server adress)
   *
   * @return string
   */
  public static function getDocUri() 
  {
    if(isset($_SERVER["DOCUMENT_URI"])) 
    {
      return $_SERVER["DOCUMENT_URI"];
    } else {
      return "/";
    }
  }
  
  public static function getValue($name)
  {
    if(isset($_REQUEST[$name]))
    {
      return $_REQUEST[$name];
    } else {
      return null;
    }
  }
  
  public static function getParameter($name)
  {
    if(!is_null($val = self::getPost($name)))
    {
      return $val;
    }
    if(!is_null($val = self::getGet($name)))
    {
      return $val;
    }
	if(isset(self::$add) && isset(self::$add[$name]))
    {
      return self::$add[$name];
    }
    return null;
  }

  /**
   * returns SESSION value
   *
   * @param type $name
   * @return null 
   */
  public static function getSession($name) 
  {
    if(isset($_SESSION[$name]))
    {
      return $_SESSION[$name];
    } else {
      return null;
    }
  }

  /**
   * set SESSION value
   *
   * @param type $name
   * @param type $value 
   */
  public static function setSession($name, $value) 
  {
    if($value === null) 
    {
      unset($_SESSION[$name]);
    } else {
      $_SESSION[$name] = $value;
    }
  }
  
  /**
   * unsets SESSION value
   * @param type $name 
   */
  public static function deleteSession($name) 
  {
    unset($_SESSION[$name]);
  }

  /**
   * returns COOKIE value
   *
   * @param type $name
   * @return null 
   */
  public static function getCookie($name) 
  {
    if(isset($_COOKIE[$name]))
    {
      return $_COOKIE[$name];
    } else {
      return null;
    }
  }
  
  /**
   * Returns page adress where request come from
   * 
   * @return string 
   */
  public static function getReferer() {
    return isset($_REQUEST["__referer"]) ? $_REQUEST["__referer"] : (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : "");
  }

  /**
   * Host
   *
   * @return type 
   */
  public static function getHost() {
    return isset($_SERVER["HTTP_X_FORWARDED_HOST"]) ? $_SERVER["HTTP_X_FORWARDED_HOST"] : (isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : "");
  }

}

?>
