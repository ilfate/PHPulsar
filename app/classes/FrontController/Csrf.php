<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

/**
 * Description of FrontController_Auth
 * 
 *
 * @author ilfate
 */
class FrontController_Csrf implements CoreInterfaceFrontController
{
  const PRIORITY = 80;
  
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

  
  
}


?>
