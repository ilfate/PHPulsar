<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

/**
 * Description of ServiceExecuter
 *
 * @author ilfate
 */
interface CoreInterfaceServiceExecuter 
{
  public function callPreServices();
  public function callPostServices();
}

?>
