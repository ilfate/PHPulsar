<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */


function ilfate_autoloader($class) {
  if(strpos($class, 'Core') === 0) {
    $path = Core::$engine_path;
    $class_edited = substr($class, 4);
  } elseif(strpos($class, 'Module') === 0) {
    $path = Core::$modules_path;
    $class_edited = substr($class, 6);
  } else {
    $path = Core::$app_path;
    $class_edited = $class;
  }
  
  if(strpos($class_edited, 'Interface') === 0) {
    $type = 'interfaces';
    $class_edited = substr($class_edited, 9);
  } else {
    $type = 'classes';
  }
  
  $file = ILFATE_PATH . $path . '/' . $type . '/' . str_replace('_', '/', $class_edited) . '.php';
  
  if (file_exists($file) && include_once($file)) {
    return TRUE;
  } else {
    trigger_error("The class '$class' or the file '$file' failed to spl_autoload", E_USER_WARNING);
    return FALSE;
  }

}


function dump() {
  $args = func_get_args();
  foreach ($args as $arg) {
    htmlspecialchars(print_r($arg));
  }
}


