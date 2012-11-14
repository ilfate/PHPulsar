<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

/**
 * Description of Main
 *
 * @author ilfate
 */
class Controller_Error extends Controller {
  //put your code here
  
  /**
   * 
   * @return type 
   */
  public static function index() {
    return array(
      'error_num' => 404,
      'tpl' => 'Error/errorPage.tpl'
    );
  }
  
  public static function page404() {
    return array(
      'error_num' => 404,
      'tpl' => 'Error/errorPage.tpl'
    );
  }
  
  public static function page500() {
    return array(
      'error_num' => 500,
      'tpl' => 'Error/errorPage.tpl'
    );
  }
  
  
}

?>
