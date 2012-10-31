<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

/**
 * Description of CoreRouting
 *
 * @author ilfate
 */
class CoreRouting implements CoreInterfaceRouting{
  
  /**
   * Executing class name
   * @var String
   */
  private $class;
  
  /**
   * Executing class method name
   * @var String
   */
  private $method;
  
  /**
   * prefix witch we will add to all route class to call
   */
  const CLASS_PREFIX = 'Controller_';
  
  const DEFAULT_CLASS = 'Main';
  const DEFAULT_METHOD = 'index';
  
  /**
   *
   * @var CoreInterfaceRequest 
   */
  private $request;
  
  public function __construct(CoreInterfaceRequest $request) 
  {
    $this->request = $request;
  }
  
  public static function __staticConstruct() 
  {
	
  }

  /**
   * returns executing class name
   * 
   * @return String
   * @throws CoreRoutingError
   */
  public function getClass() 
  {
    if($this->class) 
	{
	  return $this->class;	
	} else {
		throw new CoreRoutingError('Error on attempt to get Routing class. Routing hasint beed executed yet');
	}
  }

  /**
   * returns executing metod name
   * 
   * @return String
   * @throws CoreRoutingError
   */
  public function getMethod() 
  {
    if($this->method) 
	{
	  return $this->method;	
	} else {
		throw new CoreRoutingError('Error on attempt to get Routing method. Routing hasint beed executed yet');
	}
  }

  /**
   * Main executing method.
   * Will find a class and method for execution
   * 
   * Try to perform some layers
   * 
   * @param CoreInterfaceLayerExecuter $layerExecuter 
   * 
   * @throws CoreRoutingError
   */
  public function execute(CoreInterfaceServiceExecuter $serviceExecuter = null) 
  {
	$get = CoreRequest::getGet();
	if(!$get) // if there is no params in GET we need to set default
	{
	  $class = self::DEFAULT_CLASS;
	  $method = self::DEFAULT_METHOD;
	} else {
	  $class = key($get);
	  $method = $get[$class];
	}
	
	$prefixed_class = self::CLASS_PREFIX . $class;
	
	try {// here we try to force out autoloader.
	  // If there is no such class we will catch exception about it
	  class_exists($prefixed_class);
	} catch(CoreError $e) {
		throw new CoreRoutingError('Cant find route for "'. $class.'". Possible problem: ' . $e->getMessage());
	}
	
	if(!method_exists($prefixed_class, $method)) 
	{
		throw new CoreRoutingError('Cant find method for "'. $class . '" -> "' . $method .'"');
	}
	
	$this->class = $prefixed_class;
	$this->method = $method;
	
	$serviceExecuter->callPreServices();
	
	$response_name = Core::getConfig('Response');
	
	$obj = new $this->class();
	$response = new $response_name($obj->$method());
	
	$serviceExecuter->callPostServices();
	return $response;
  }
}


/**
 * Core Routing Error.
 */
class CoreRoutingError extends CoreError {}

?>
