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
class Service_Csrf extends CoreService
{
  public static function preExecute() 
  {
    if(Request::getMethod() == "POST")
    {
      if(!Csrf::check())
	  {
		  throw new CoreException_Error('No CSRF token found');
	  }
    }
  }
  
  public static function postExecute() 
  {
  }

  public static function getPriority() {
    return 5;
  }
  
  
}


?>
