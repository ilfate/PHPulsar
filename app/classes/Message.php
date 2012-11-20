<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

/**
 * Message class 
 *
 * @author ilfate
 */
class Message
{
  const SESSEION_KEY = 'ilfate_message';
  
  /**
   * creates message
   *
   * @param String $message 
   */
  public static function add($message)
  {
	  $messages = Request::getSession(self::SESSEION_KEY);
	  $messages[] = $message;
	  Request::setSession(self::SESSEION_KEY, $messages);
  }
  
  public static function getMessages()
  {
    return Request::getSession(self::SESSEION_KEY);
  }
  
  public static function clear()
  {
    Request::setSession(self::SESSEION_KEY, null);
  }
}

?>
