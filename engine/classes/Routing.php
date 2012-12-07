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
  protected static $class;
  
  /**
   * Executing class method name
   * @var String
   */
  protected static $method;
  
  protected static $save;
  
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
  private static $request;
  
  public function __construct(CoreInterfaceRequest $request) 
  {
    self::$request = $request;
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
  public static function getClass() 
  {
    if(self::$class) 
    {
      return self::$class;  
    } else {
      throw new CoreException_RoutingError('Error on attempt to get Routing class. Routing hasint beed executed yet');
    }
  }
  
  /**
   * returns executing class name
   * 
   * @return String
   * @throws CoreRoutingError
   */
  public static function getPrefixedClass() 
  {
    return self::CLASS_PREFIX . static::getClass();
  }

  /**
   * returns executing metod name
   * 
   * @return String
   * @throws CoreRoutingError$prefixed_class
   */
  public static function getMethod() 
  {
    if(self::$method) 
    {
      return self::$method;  
    } else {
      throw new CoreException_RoutingError('Error on attempt to get Routing method. Routing hasint beed executed yet');
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
  public function execute() 
  {
    $get = Request::getGet();
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
      throw new CoreException_RoutingError('Cant find route for "'. $class.'". Possible problem: ' . $e->getMessage());
    }

    if(!method_exists($prefixed_class, $method) && !method_exists($prefixed_class, '_' . $method) ) 
    {
      throw new CoreException_RoutingError('Cant find method for "'. $class . '" -> "' . $method .'"');
    }

    self::$class = $class;
    self::$method = $method;
  }
  
  
  /**
   * Save current rouring and sets new fake params
   * 
   * @param type $get
   * @param type $post 
   */
  public function setFakeRouting($class, $method)
  {
    $data = array('class' => $this->getClass(), 'method' => $this->getMethod());
    if(!self::$save)
    {
      self::$save = array($data);
    } else {
      self::$save[] = $data;
    }
    self::$class = $class;
    self::$method = $method;
  }
  
  /**
   * Restore previous routing params
   */
  public function restoreRouting()
  {
    if(self::$save)
    {
      $data = array_pop(self::$save);
      self::$class = $data['class'];
      self::$method = $data['method'];
    } else {
      throw new CoreException_RoutingError('Cant restore Routing settings.');
  }
  }
  
  /**
   * Revers routing. Creates url from Class and Method
   * 
   * @param string $class
   * @param string $method
   * @return string
   */
  public function getUrl($class, $method)
  {
    return '?' . $class . '=' . $method;
  }
  
  public function getDefaultLayout()
  {
    $class_name = static::getPrefixedClass();
    return $class_name::$layout;
  }
}

?>
