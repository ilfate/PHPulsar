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
  
  const EXECUTE_MODE_HTTP = 'http';
  const EXECUTE_MODE_HTTP_AJAX = 'ajax';
  const EXECUTE_MODE_HTTP_SUBQUERY = 'subquery';
  const EXECUTE_MODE_CLI = 'cli';

  private $executingMode;

  //put your code here
  public function getRequest() {
    
  }
  
  public function __construct() {
    $escape_function = function(&$item, $key) {
      $item = htmlentities($item);
      $item = mysql_real_escape_string($item);
    };
    self::$post = $_POST;
    self::$get = $_GET;
    
    if(self::$post) {
      array_walk_recursive(self::$post, $escape_function);
    }
    if(self::$get) {
      array_walk_recursive(self::$get, $escape_function);
    }
  }
  
  /**
   * return array with POST like $_POST
   * 
   * @return Array
   */
  public static function getPost() {
    return self::$post;
  }
  
  /**
   * return array with GET like $_GET
   * 
   * @return Array
   */
  public static function getGet() {
    return self::$get;
  }
  
  /**
   * return one of the possible executing modes.
   * 
   * @return string
   */
  public function getExecutingMode() {
	if(!$this->executingMode) 
	{
	  // if no mode setted, let it be HTTP
	  $this->executingMode = self::EXECUTE_MODE_HTTP;
	}
	return $this->executingMode;
  }
}

?>
