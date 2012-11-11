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
  const EXECUTE_MODE_HTTP_AJAX = 'ajax';
  const EXECUTE_MODE_HTTP_SUBQUERY = 'subquery';
  const EXECUTE_MODE_CLI = 'cli';
  
  const PARAM_AJAX = '__ajax';

  private static $executingMode;

  //put your code here
  public function getRequest() 
  {
    
  }
  
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
  public static function getPost() 
  {
    return self::$post;
  }
  
  /**
   * return array with GET like $_GET
   * 
   * @return Array
   */
  public static function getGet() 
  {
    return self::$get;
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
      if(isset(self::$get[self::PARAM_AJAX]))
      {
        self::$executingMode = self::EXECUTE_MODE_HTTP_AJAX;
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
}

?>
