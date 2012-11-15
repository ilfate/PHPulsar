<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

/**
 * Description of Service_Auth
 * 
 *
 * @author ilfate
 */
class Service_Auth extends CoreService
{
  const SESSION_AUTH_KEY = 'user_auth';
  const SESSION_AUTH_KEY_EXPIRES = 3600;
	
  /**
   *
   * @var Boolean 
   */
  private static $authorized = false;
	
  public static function preExecute() 
  {
	  // try auth via session
    if($session = Request::getCookie(self::SESSION_AUTH_KEY))
	{ // if session exists
	  if(time() < ($session['time'] + self::SESSION_AUTH_KEY_EXPIRES))
	  { // if seesion if not expired
	    $id_user = $session['id'];
	  }
	} else {
	  // try auth via cookie	
	} 
  }
  
  
  
  public static function postExecute() 
  {
  }
  
  private static function saveSession($id_user)
  {
	$session= array(
	  'id'   => $id_user,
	  'time' => time()
	);
	Request::setSession(self::SESSION_AUTH_KEY, $session);
  }
  
  public static function isAuth()
  {
	return self::$authorized;
  }

  public static function getPriority() {
    return 5;
  }
  
  
}


?>
