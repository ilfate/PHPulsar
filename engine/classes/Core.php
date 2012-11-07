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
   * @var array
   */
  private static $views;
  
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

      self::$request = new Request();
      self::$routing = self::initModule('Routing', array(self::$request));
    
    if(self::$request->getExecutingMode() == Request::EXECUTE_MODE_HTTP) 
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
    
    // define routing class and method
    self::$routing->execute();
    
    try
    {
      // here we execute services BEFORE main content
      self::$serviceExecuter->callPreServices();

      $class = self::$routing->getPrefixedClass();
      $method = self::$routing->getMethod();
      $response = Core::initResponse($class::$method());
      self::output($response);
      // here we execute services AFTER main content
      self::$serviceExecuter->callPostServices();
    } catch (Exception $e) {
      throw $e;
    }
    
  }
  
  /**
   * Creates new core execution ( like open link with anther link )
   * And return result of this execution
   * instead of url we use here direct class and method names
   * it is just simplier and faster coz we dont need to use Routing
   * 
   * @param String $class    Class name that we want to execute
   * @param String $method   Method name that we want to excute
   * @param Array  $get      Array with all get params that we want to pass to 
   * that script. It will have its own GET array
   * @param Arrya  $post     Array with all post params that we want to pass to 
   * that script. It will have its own POST array
   * @return String
   */
  public static function subExecute($class, $method, $get, $post)
  {
    self::$request->setFakeRequest($get, $post);
    self::$routing->setFakeRouting($class, $method);
    
    $call_class = self::$routing->getPrefixedClass();
    $call_method = self::$routing->getMethod();
    $response = Core::initResponse($call_class::$call_method());
    
    $return = self::output($response, true);
    
    self::$routing->restoreRouting();
    self::$request->restoreRequest();
    return $return;
  }
  
  /**
   * This function takes response and flushs it
   * 
   * @param CoreInterfaceResponse $response
   */
  public static function output(CoreInterfaceResponse $response, $return_string = false)
  {
    $content = $response->getContent();

    if(!$return_string)
    {
      echo $content;
    } else {
      return $content;
    }
  }
  
  /**
   * Init and returns response object
   * 
   * @param type $content
   */
  public static function initResponse($content) 
  {
    if(!isset(self::$config['project']['Response'][self::$request->getExecutingMode()])) 
    {
      throw new CoreException_Error('Cant find Response implementation class for "' . self::$request->getExecutingMode() . '" in config');
    } 
    if(!isset(self::$views[self::$request->getExecutingMode()]))
    {
      if(isset(self::$config['project']['View'][self::$request->getExecutingMode()])) 
      {
        self::$views[self::$request->getExecutingMode()] = new self::$config['project']['View'][self::$request->getExecutingMode()]();
      } else {
      self::$views[self::$request->getExecutingMode()] = null;
      }
    }
    return new self::$config['project']['Response'][self::$request->getExecutingMode()]($content, self::$routing, self::$views[self::$request->getExecutingMode()]);
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
  
  
  public static function createUrl($class, $method)
  {
	return self::$routing->getUrl($class, $method);
  }
}

?>
