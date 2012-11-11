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
class Service_Layout extends CoreService
{
	public static function preExecute() 
  {
    CoreView_Http::setGlobal('page_title', 'Ilfate');
  }
  
  public static function postExecute() 
  {
  }

  public static function getPriority() {
    return 5;
  }
  
  
}


?>
