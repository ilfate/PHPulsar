<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

/**
 * Description of Auth
 *
 * @author ilfate
 */
class Controller_Auth extends Controller {
  //put your code here
  
  /**
   * 
   * @return type 
   */
  public function logInForm() 
  {
    return array(
      'mode' => Request::EXECUTE_MODE_HTTP,
      'tpl' => 'Auth/loginForm.tpl',
      ''
    );
  }
  
  
  /**
   * 
   * @return type 
   */
  public function signUpForm() 
  {
    return array(
      'mode' => Request::EXECUTE_MODE_HTTP,
      'tpl' => 'Auth/signUpForm.tpl',
      ''
    );
  }
  
  
  public function signUp()
  {
    $post = Request::getPost();
    return array(
      'sucsess' => true,
      'er'      => Request::getPost(),
      'actions' => array('Modal.close'),
      'args'    => array('arg')
    );
  }
  
  
}

?>
