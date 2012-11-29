<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

/**
 * Description of RobotRock
 *
 * @author ilfate
 */
class Controller_RobotRock extends Controller {
  //put your code here
  
  public function index() 
  {
    Service_Layout::addSideBar('RobotRock', 'info');
    return array(
      'layout' => array('html.tpl', 'RobotRock/head.tpl', 'layout.tpl')
    ); 
  }
  
  public function info() 
  {
    return array(
      
    ); 
  }
}

?>
