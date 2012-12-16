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
  
  /**
   * keeps all initiaalized controllers
   *
   * @var array 
   */
  private static $stored_controllers = array();
  
  
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

    session_start();

    include ILFATE_PATH . '/engine/functions.php';

    self::$config =  require 'config.php';

    spl_autoload_register('ilfate_autoloader');

    self::$request = new Request();
    self::$routing = new Routing(self::$request);

    switch (Request::getExecutingMode())
    {
      case Request::EXECUTE_MODE_HTTP : {
        self::commonExecuting();
      } break;
      case Request::EXECUTE_MODE_HTTP_AJAX : 
      case Request::EXECUTE_MODE_AJAX : {
        self::ajaxExecuting();
      } break;
    }
  }
  
  /**
   * Normal executing
   */
  public static function commonExecuting() 
  {
    
    try
    {
      self::$serviceExecuter = new ServiceExecuter();

      // define routing class and method
      self::$routing->execute();
    
      // here we execute services BEFORE main content
      self::$serviceExecuter->callPreServices();

      $class = self::$routing->getPrefixedClass();
      $method = self::$routing->getMethod();
      $obj = self::getController($class);
      $response = Core::initResponse($obj->$method());
      
      Runtime::setHttpHeader("Content-Type", "text/html; charset=utf-8");
      $response->setHeaders();
      
      self::output($response);
      // here we execute services AFTER main content
      self::$serviceExecuter->callPostServices();
    } catch (Exception $e) {
      Logger::dump($e->getMessage(), 'file', 'CoreError.log');
      if(self::getConfig('is_dev')) 
      {
        throw $e;
      } else {
        Helper::redirect('Error', 'page500');
      }
    }
    
  }
  
  /**
   * Ajax executing
   */
  public static function ajaxExecuting() 
  {
    
    try
    {
      self::$serviceExecuter = new ServiceExecuter();

      // define routing class and method
      self::$routing->execute();
    
      // here we execute services BEFORE main content
      self::$serviceExecuter->callPreServices();

      $class = self::$routing->getPrefixedClass();
      $method = self::$routing->getMethod();
      $obj = self::getController($class);
      $response = Core::initResponse($obj->$method());
      
      Runtime::setHttpHeader("Content-Type", "application/json; charset=utf-8");
      $response->setHeaders();
      
      self::output($response);
      // here we execute services AFTER main content
      self::$serviceExecuter->callPostServices();
    } catch (Exception $e) {
      Logger::dump($e->getMessage(), 'file', 'CoreError.log');
      if(self::getConfig('is_dev')) 
      {
        throw $e;
      } else {
        Helper::redirect('Error', 'page500');

      }
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
    $obj = self::getController($call_class);
    $response = Core::initResponse($obj->$call_method());
    
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

    $headers = $response->setHeaders();
    
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
   * @param CoreInterfaceResponse $content
   */
  public static function initResponse($content) 
  {
    if(is_array($content) && isset($content['mode']))
    {
      $mode = $content['mode'];
    } else {
      $mode = Request::getExecutingMode();
    }
    
    if(!isset(self::$config['project']['Response'][$mode])) 
    {
      throw new CoreException_Error('Cant find Response implementation class for "' . $mode . '" in config');
    }
    
    if(!isset(self::$views[$mode]))
    {
      if(isset(self::$config['project']['View'][$mode])) 
      {
        self::$views[$mode] = new self::$config['project']['View'][$mode]();
      } else {
      self::$views[$mode] = null;
      }
    }
    
    return new self::$config['project']['Response'][$mode]($content, self::$routing, self::$views[$mode]);
  }
  
  /**
   * Returns main project configuration field
   * 
   * @param type $name
   * @return mixed
   */
  public static function getConfig($name) 
  {
    if(isset(self::$config['project'][$name]))
    {
      return self::$config['project'][$name];
    } else {
      return null;
    }
  }
  
  /**
   * Returns extended project configuration field
   * 
   * @param type $name
   * @return mixed
   */
  public static function getExtendedConfig($type, $name) 
  {
    if(isset(self::$config[$type]) && isset(self::$config[$type][$name]))
    {
      return self::$config[$type][$name];
    } else {
      return null;
    }
  }
  
  /**
   * crete url via routing
   *
   * @param type $class
   * @param type $method
   * @return type 
   */
  public static function createUrl($class, $method)
  {
    return self::$routing->getUrl($class, $method);
  }
  
  private static function getController($name)
  {
    if(!isset(self::$stored_controllers[$name]))
    {
      self::$stored_controllers[$name] = new $name();
    }
    return self::$stored_controllers[$name];
  }
}

?>
