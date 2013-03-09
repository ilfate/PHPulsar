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
  
  protected $post;
  protected $get;
  protected $save;
  
  
  const EXECUTE_MODE_HTTP = 'http';
  const EXECUTE_MODE_AJAX = 'ajax';
  const EXECUTE_MODE_HTTP_AJAX = 'http_ajax';
  const EXECUTE_MODE_HTTP_SUBQUERY = 'subquery';
  const EXECUTE_MODE_CLI = 'cli';
  
  const PARAM_AJAX      = '__ajax';
  const PARAM_AJAX_HTML = '__html';

  protected $executingMode;
  
  public function __construct() 
  {
    $escape_function = function(&$item, $key) {
      $item = htmlentities($item);
      //$item = mysql_real_escape_string($item);
    
    };
    
    $this->get = $_GET;
    $this->post = $_POST;
       
    if ($this->post) {
      array_walk_recursive($this->post, $escape_function);
    }
    if ($this->get) {
      array_walk_recursive($this->get, $escape_function);
    }
  }
  
  /**
   * return array with POST like $_POST
   * 
   * @return Array
   */
  public function getPost($param = null)
  {
    if (!$param) {
      return $this->post;
    } elseif (isset($this->post[$param])) {
      return $this->post[$param];
    } else {
      return null;
    }
  }
  
  /**
   * return array with GET like $_GET
   * 
   * @return Array
   */
  public function getGet($param = null)
  {
    if (!$param) {
      return $this->get;
    }
    if (!isset($this->get[$param])) {
      return null;
    }
    return $this->get[$param];
  }
  
  /**
   * Returns method
   */
  public function getMethod()
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
    $data = array('get' => $this->get, 'post' => $post, 'mode' => $this->getExecutingMode());
    if (!$this->save) {
      $this->save = array($data);
    } else {
      $this->save[] = $data;
    }
    $this->get = $get;
    $this->post = $post;
    $this->executingMode = self::EXECUTE_MODE_HTTP_SUBQUERY;
    return $this;
  }
  
  public function restoreRequest()
  {
    if ($this->save) {
      $data = array_pop($this->save);
      $this->get = $data['get'];
      $this->post = $data['post'];
      $this->executingMode = $data['mode'];
    }
    return $this;
  }
  
  /**
   * return one of the possible executing modes.
   * 
   * @return string
   */
  public function getExecutingMode()
  {
    if (!$this->executingMode) {
      if (isset($this->get[self::PARAM_AJAX]) && isset($this->get[self::PARAM_AJAX_HTML])) {
        $this->executingMode = self::EXECUTE_MODE_HTTP_AJAX;
	    } elseif (isset($this->get[self::PARAM_AJAX]) && !isset($this->get[self::PARAM_AJAX_HTML])) {
        $this->executingMode = self::EXECUTE_MODE_AJAX;
      } else {
        // if no mode setted, let it be HTTP
        $this->executingMode = self::EXECUTE_MODE_HTTP;
      }
    }
    return $this->executingMode;
  }
  
  
  /**
   * Get user IP
   *
   * @return string
   */
  public function getRemoteAddress()
  {
    return
      (isset($_SERVER["HTTP_X_FORWARDED_FOR"]) && !empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
        ? $_SERVER["HTTP_X_FORWARDED_FOR"]
        : $_SERVER["REMOTE_ADDR"];
  }
  
  /**
   * Get URI of the request (without server adress)
   *
   * @return string
   */
  public function getUri()
  {
    if (isset($_SERVER["REQUEST_URI"])) {
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
  public function getDocUri()
  {
    if (isset($_SERVER["DOCUMENT_URI"])) 
    {
      return $_SERVER["DOCUMENT_URI"];
    } else {
      return "/";
    }
  }
  
  public function getValue($name)
  {
    if (isset($_REQUEST[$name])) {
      return $_REQUEST[$name];
    } else {
      return null;
    }
  }
  
  public function getParameter($name)
  {
    if (!is_null($val = $this->getPost($name))) {
      return $val;
    }
    if (!is_null($val = $this->getGet($name))) {
      return $val;
    }
	  if (isset($this->add) && isset($this->add[$name])) {
      return $this->add[$name];
    }
    return null;
  }

  /**
   * returns SESSION value
   *
   * @param type $name
   * @return null 
   */
  public function getSession($name)
  {
    if (isset($_SESSION[$name])) {
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
  public function setSession($name, $value)
  {
    if ($value === null) {
      unset($_SESSION[$name]);
    } else {
      $_SESSION[$name] = $value;
    }
  }
  
  /**
   * unsets SESSION value
   * @param type $name 
   */
  public function deleteSession($name)
  {
    unset($_SESSION[$name]);
  }

  /**
   * returns COOKIE value
   *
   * @param type $name
   * @return null 
   */
  public function getCookie($name)
  {
    if (isset($_COOKIE[$name])) {
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
  public function getReferer() {
    return isset($_REQUEST["__referer"])
      ? $_REQUEST["__referer"]
      : (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : "");
  }

  /**
   * Host
   *
   * @return type 
   */
  public function getHost() {
    return isset($_SERVER["HTTP_X_FORWARDED_HOST"])
      ? $_SERVER["HTTP_X_FORWARDED_HOST"]
      : (isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : "");
  }

}
