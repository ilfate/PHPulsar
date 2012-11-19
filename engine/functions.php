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
  
  if (file_exists($file) && include_once($file)) 
  {
    if(method_exists($class, '__staticConstruct')) 
    {
 	  try{
		call_user_func($class.'::__staticConstruct');
	  } catch (Exception $e) {
		  if(Core::getConfig('is_dev')) {
			  echo $e->getMessage();
		  }
		  //throw new CoreException_Error("The class '$class' or the file '$file' failed to spl_autoload. Reason:" . $e->getMessage());
		  Logger::dump("The class '$class' or the file '$file' failed to spl_autoload. Reason:" . $e->getMessage());
		  exit;
	  }
	  
    }
    return TRUE;
  } else {
    //trigger_error("The class '$class' or the file '$file' failed to spl_autoload", E_USER_WARNING);
    //throw new CoreException_Error("The class '$class' or the file '$file' failed to spl_autoload");
	Logger::dump("The class '$class' or the file '$file' failed to spl_autoload.");
    return FALSE;
  }

}


/**
 * Somewhat naive way to determine if an array is a hash.
 */
function is_hash(&$array)
{
  if (!is_array($array))
    return false;

  $keys = array_keys($array);
  return @is_string($keys[0]) ? true : false;
}

