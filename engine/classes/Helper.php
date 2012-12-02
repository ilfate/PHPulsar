<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

/**
 * Helper class 
 *
 * @author ilfate
 */
class CoreHelper
{
  
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
  public static function exe($class, $method, $get = null, $post = null)
  {
    return Core::subExecute($class, $method, $get, $post);
  }
  
  public static function exeAjax($class, $method, $get = null)
  {
    
    $div_id = 'ajax_load_'.  mt_rand(1000, 9999);
    $url = self::url($class, $method, $get);
    Js::add(Js::C_ONAFTERLOAD, 'Ajax.html("'.$url.'", "#'.$div_id.'")');
    return '<div id="'.$div_id.'"></div>';
  }
  
  /**
   * Generates url using Roution to create url from path
   *
   * @param String $class
   * @param String $method
   * @param array  $get
   * @return String 
   */
  public static function url($class = null, $method = null, array $get = null)
  {
    if(!$class)
    {
      $class = Routing::DEFAULT_CLASS;
    }
    if(!$method) 
    {
      $method = Routing::DEFAULT_METHOD;
    }
    $url = Core::createUrl($class, $method);
    if($get)
    {  
        $url .= (strpos($url, '?') === false) ? '?' : '&';
      $url .= http_build_query($get);
    }
    return $url;
  }
  
  /**
   * Generates url using Roution to create url from path
   *
   * @param String $class
   * @param String $method
   * @param array  $get
   * @return String 
   */
  public static function urlAjax($class = null, $method = null, array $get = null)
  {
    $get = array_merge((array)$get, array(Request::PARAM_AJAX => 'true'));   
    return self::url($class, $method, $get);
  }
  
  
  
  /**
   * Redirects to some route
   * 
   * @param string $class
   * @param string $method
   * @param array  $get 
   */
  public static function redirect($class = null, $method = null, array $get = null)
  {
    $url = Helper::url($class, $method, $get);
    header('Location: ' . $url);
  }
  
  
  
 
}

?>
