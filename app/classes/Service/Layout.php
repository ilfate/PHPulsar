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
    $access_restricted = Request::getGet('access_restricted');
    CoreView_Http::setGlobal('page_title', 'Ilfate');
    CoreView_Http::setGlobal('access_restricted', $access_restricted);
    
    if(Request::getExecutingMode() == Request::EXECUTE_MODE_HTTP)
    {
      $messages = Message::getMessages();
      if($messages) 
      {
        foreach ($messages as $message)
        {
          Js::add(Js::C_ONLOAD, "ilAlert('$message');");
        }
        Message::clear();
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
