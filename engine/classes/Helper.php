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
  
  
  
 
}

?>
