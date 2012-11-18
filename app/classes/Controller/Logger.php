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
class Controller_Logger extends Controller {
  //put your code here
  
  /**
   * 
   * @return type 
   */
  public function index() {
    $queryes = Logger::sql_getLog();
    $variables = Logger::getDump();
    return array(
      'queryes' => $queryes,
      'variables' => is_array($variables) ? $variables : array()
    );
  }
  
  
}

?>
