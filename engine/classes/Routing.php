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
   *
   * @var CoreInterfaceRequest 
   */
  private $request;
  
  public function __construct(CoreInterfaceRequest $request) {
    $this->request = $request;
  }
  
  public static function __staticConstruct() {
	
  }

  public function getClass() {
    
  }

  public function getMethod() {
    
  }

  public function execute() {
	$get = CoreRequest::getGet();
	$controller = key($get);
	$method = $get[$controller];
	try {
	  class_exists('Controller_'.$controller);
	} catch(CoreError $e) {
		throw new CoreRoutingError('Cant');
	}
	if(!method_exists($method, $method_name)) {
		
	}
  }
}


/**
 * Core Routing Error.
 */
class CoreRoutingError extends CoreError {}

?>
