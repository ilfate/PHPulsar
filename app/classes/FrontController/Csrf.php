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
class FrontController_Csrf implements InterfaceFrontController
{
  const PRIORITY = 80;
  
  public static function preExecute() 
  {
    if (Service::getRequest()->getMethod() == "POST") {
      if (!Csrf::check()) {
		    throw new Error('No CSRF token found');
	    }
    }
  }
  
  public static function postExecute() 
  {
  }

  
  
}
