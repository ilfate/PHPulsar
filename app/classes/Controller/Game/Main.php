<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

/**
 * Description of Game
 *
 * @author ilfate
 */
class Controller_Game_Main extends Controller {
  //put your code here
  
  
  /**
   * 
   * @return type 
   */
  public function index() 
  {
      
    return array(
      'mode' => Request::EXECUTE_MODE_HTTP,
      'tpl' => 'Game/index.tpl'
    );
  }
  
  /**
   * 
   * @return type 
   */
  public function gameWindow() 
  {
    return array(
      'mode' => Request::EXECUTE_MODE_HTTP,
      'tpl' => 'Game/gameWindow.tpl'
    );
  }
}

?>
