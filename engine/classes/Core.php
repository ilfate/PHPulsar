<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

/**
 * Core engine class
 * we start our travel at here
 *
 * @author ilfate
 */
class Core {
  
  public static $engine_path  = '/engine';
  public static $app_path     = '/app';
  public static $modules_path = '/modules';
  
  /**
   *
   * @var CoreInterfaceRequest 
   */
  private static $request;
  
  /**
   *
   * @var CoreInterfaceRouting 
   */
  private static $routing;
  
  /**
   *
   * @var CoreInterfaceServiceExecuter
   */
  private static $serviceExecuter;
  
  /**
   * Project configuration
   * @var mixed 
   */
  private static $config;
  
  /**
   * shows is Core initialized
   * @var Boolean
   */
  private static $inited = false;
  /**
   * we close it for singltone
   */
  private function __construct() 
  {
    self::init();
  }
  /*
   * here we start to build all we need for our engine
   */
  public static function init() 
  {
    if(self::$inited) 
	{
      die("Fatal error. Attempt to init Core second time");
    }
    self::$inited = true;
    
    include ILFATE_PATH . '/engine/functions.php';
    
    self::$config =  require 'config.php';
    
    spl_autoload_register('ilfate_autoloader');

    self::$request = self::initModule('Request');
    self::$routing = self::initModule('Routing', array(self::$request));
    
	if(self::$request->getExecutingMode() == CoreRequest::EXECUTE_MODE_HTTP) 
	{
	  self::commonExecuting();
	}
  }
  
  /**
   * Normal executing
   */
  public static function commonExecuting() 
  {
	self::$serviceExecuter = self::initModule('ServiceExecuter');
	
    self::$routing->execute(self::$serviceExecuter);
  }
  
  /**
   * Init and returns response object
   * 
   * @param type $content
   */
  public static function initResponse($content) 
  {
	  if(isset(self::$config['project']['Response'][self::$request->getExecutingMode()])) 
	  {
		return new self::$config['project']['Response'][self::$request->getExecutingMode()]($content, self::$routing);
	  } else {
		throw new CoreException_Error('Cant find Response implementation class for "' . self::$request->getExecutingMode() . '" in config');
	  }
  }
  
  
  
  private static function initModule($name, Array $args = array()) 
  {
    if(!isset(self::$config['project'][$name]) || !self::$config['project'][$name]) 
	{
		throw new CoreException_Error('Can init module '. $name.'. This module class must appear in config', 101);
    }
	
    if(!class_exists(self::$config['project'][$name])) 
	{
		throw new CoreException_Error('Can init module '. $name.'. Class not found', 102);
    }
	
    if(count($args) == 0)
	{
      return new self::$config['project'][$name];
    } else {
      $r = new ReflectionClass(self::$config['project'][$name]);
      return $r->newInstanceArgs($args);
    }
  }
  
  public static function getConfig($name) 
  {
    if(isset(self::$config['project'][$name]))
	{
	  return self::$config['project'][$name];
	} else {
	  return null;
	}
  }
}

?>
