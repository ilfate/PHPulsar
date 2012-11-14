<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

/**
 * Description of Response
 *
 * @author ilfate
 */
interface CoreInterfaceResponse 
{
  public function __construct($result, CoreInterfaceRouting $routing, CoreInterfaceView $view = null);
  
  public function getContent();
  public function setHeaders();
}

?>
