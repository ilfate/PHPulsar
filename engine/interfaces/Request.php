<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

/**
 * Description of Request
 *
 * @author ilfate
 */
interface CoreInterfaceRequest {
  
  public function getPost();
  public function getGet();
  
  public function getExecutingMode();
  
  public function getValue($name);


  public function getSession($name);
  public function setSession($name, $value);
  public function deleteSession($name);
  
  public function getCookie($name);

}
