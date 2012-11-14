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
  
  public static function getPost();
  public static function getGet();
  
  public static function getExecutingMode();
  
  public static function getValue($name);


  public static function getSession($name);
  public static function setSession($name, $value);
  public static function deleteSession($name);
  
  public static function getCookie($name);
  
}

?>
