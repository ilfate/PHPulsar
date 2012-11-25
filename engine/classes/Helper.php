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
  
  public static function exeAjax($route, $get = null)
  {
    
    $div_id = 'ajax_load_'.  mt_rand(1000, 9999);
    $url = self::url($route, $get);
    Js::add(Js::C_ONAFTERLOAD, 'Ajax.html("'.$url.'", "#'.$div_id.'")');
    return '<div id="'.$div_id.'"></div>';
  }
  
  /**
   * Generates url using Roution to create url from path
   *
   * @param array $route
   * @param array $get
   * @return String 
   */
  public static function url(array $route, array $get = null)
  {
    list($class, $method) = $route;
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
   * @param array $route
   * @param array $get
   * @return String 
   */
  public static function urlAjax(array $route, array $get = null)
  {
    $get = array_merge((array)$get, array(Request::PARAM_AJAX => 'true'));   
    return self::url($route, $get);
  }
  
  
  
  /**
   * Redirects
   * $redirect_way could be "direct_link.com" or array('class', 'method')
   *
   * @param Mixed $redirect_way
   * @param array $get 
   */
  public static function redirect($redirect_way= null, array $get = null)
  {
    if(is_string($redirect_way))
    {
        $url = $redirect_way;
    } elseif(is_array($redirect_way)) 
    {
        $url = Helper::url($redirect_way, $get);
    } else {
      $url = Helper::url(array(Routing::DEFAULT_CLASS, Routing::DEFAULT_METHOD), $get);
    }
    header('Location: ' . $url);
  }
  
  
  
 
}

?>
