<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

/**
 * Description of Service
 *
 * @author ilfate
 */
interface CoreInterfaceService 
{
  public static function preExecute();
  public static function postExecute();
  
  // Must return int between 1 and 100
  public static function getPriority();
}

?>
