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
  
  private $post;
  private $get;
  
  //put your code here
  public function getRequest() {
    
  }
  
  public function __construct() {
    $escape_function = function(&$item, $key) {
      $item = htmlentities($item);
      $item = mysql_real_escape_string($item);
    };
    $this->post = $_POST;
    $this->get = $_GET;
    
    if($this->post) {
      array_walk_recursive($this->post, $escape_function);
    }
    if($this->get) {
      array_walk_recursive($this->get, $escape_function);
    }
  }
  
  public function getPost() {
    return $this->post;
  }
  public function getGet() {
    return $this->get;
  }
}

?>
