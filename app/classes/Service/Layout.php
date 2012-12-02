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
  const PRIORITY = 70;
  
  private static $menu = array(
    'main'        => array('class' => 'Main',       'method' => 'index',    'text' => 'Main'),
    'about_me'    => array('class' => 'Cv',         'method' => 'aboutMe',  'text' => 'About me'),
    'game'	      => array('class' => 'Game_Main',  'method' => 'index',    'text' => 'Game'),
  );
  private static $menu_map = array(
    'Auth'   => 'main',
    'Main'   => array('index' => 'main', 'aboutMe' => 'about_me' ),
    'Cv'     => 'about_me',
    'Game'   => 'game',
  );
  
  private static $default_menu = 'main';
  
  private static $side_bars = array();
  
  public static function preExecute() 
  {
    if(Request::getExecutingMode() == Request::EXECUTE_MODE_HTTP)
    {
      $access_restricted = Request::getGet('access_restricted');
      CoreView_Http::setGlobal('page_title', 'Ilfate');
      CoreView_Http::setGlobal('access_restricted', $access_restricted);

      /**
       * Menu handler 
       */
      $class = Routing::getClass();
      if(isset(self::$menu_map[$class]))
      {
        if(is_array(self::$menu_map[$class]))
        {
          $method = Routing::getMethod();
          if(isset(self::$menu_map[$class][$method])) 
          {
            $active_menu = self::$menu_map[$class][$method];
          }
        } else {
          $active_menu = self::$menu_map[$class];
        }
      }
      if(!isset($active_menu)) 
      {
        $active_menu = self::$default_menu;
      }
      self::$menu[$active_menu]['active'] = true;
      CoreView_Http::setGlobal('ilfate_menu', self::$menu);

      /**
       * Messages handler 
       */
    
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
  
  public static function getSideBar()
  {
    $return = '';
    if(self::$side_bars)
    {
      foreach (self::$side_bars as $route)
      {
        $return .= Helper::exe($route[0], $route[1]);
      }
    }
    return $return;
  }
  
  public static function addSideBar($class, $method)
  {
    self::$side_bars[] = array($class, $method);
  }
  
  public static function postExecute() 
  {
    
  }

  
  
}


?>
