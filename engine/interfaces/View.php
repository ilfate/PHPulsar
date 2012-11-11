<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

/**
 * Description of View
 *
 * @author ilfate
 */
interface CoreInterfaceView 
{
  
  // render some data
  public function render($template , $values, array $layout);
  
}

?>
