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
	public static function preExecute() 
  {
    dump('Auth<br>'); 
  }
  
  public static function postExecute() 
  {
  }

  public static function getPriority() {
    return 5;
  }
  
  
}


?>
