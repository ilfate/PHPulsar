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
    if(!Validator::validateForm(
      array(
        'email' => array('notEmpty', array('minLength', 3), 'email', 'userEmailUnique'),
		'pass'  => array('notEmpty', array('equalField', 'pass2'), array('minLength', 6)),
        'name'  => array('notEmpty', array('minLength', 4), array('maxLength', 16), 'userNameUnique'),
      )  
    ))
    {
      return Validator::getFormErrorAnswer();
    }
	
	$post = Request::getPost();
	Model_User::createUserWithEmail($post['email'], $post['pass'], $post['name']);
	
    return array(
      'sucsess' => true,
      'actions' => array('Action.refresh'),
    );
  }
  
  
}

?>
