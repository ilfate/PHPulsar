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
class Controller_Cv extends Controller {
  //put your code here
  
  public function index() 
  {
	return $this->aboutMe(); 
  }
	
	
  /**
   * 
   * @return type 
   */
  public function aboutMe() 
  {
      
    return array(
      'mode' => Request::EXECUTE_MODE_HTTP,
      'tpl' => 'Main/aboutMe.tpl'
    );
  }
  
  /**
   * 
   * @return type 
   */
  public function skills() 
  {
    return array(
      'mode' => Request::EXECUTE_MODE_HTTP,
      'tpl' => 'Main/skills.tpl'
    );
  }
}

?>
