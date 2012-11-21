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
class Controller_MainPages extends Controller {
  //put your code here
  
  /**
   * 
   * @return type 
   */
  public function aboutMe() 
  {
      
    return array(
      'tpl' => 'Main/index.tpl'
    );
  }
}

?>
