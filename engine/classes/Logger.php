<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

/**
 * Description of CoreLogger
 *
 * @author ilfate
 */
class CoreLogger 
{
  
  const VARIABLES_OUTPUT = 'output';
  const VARIABLES_LOGGER = 'logger';
  /**
   * is Logger needed
   *
   * @var Boolean 
   */
  private static $is_logger_enabled = true;
  
  private static $is_output_enabled = false;
  
  private static $is_file_logging_enabled = true;
  
  private static $log_file = 'CoreLog.log';
  private static $log_path = '';
  
  private static $is_day_logging = false;
  
  private static $is_log_sql = false;
  
  /**
   * Shows is Sql query logging is enabled
   * @var type 
   */
  private static $sql_logger;
  
  /**
   * Could be 'logger' OR 'output'
   *
   * @var String 
   */
  private static $variable_logging = self::VARIABLES_LOGGER;
  
  private static $variables_container;
  
  
  public static function __staticConstruct() {
    self::$is_log_sql = Core::getConfig('log_sql');
    self::$log_path = Core::getConfig('logs_path');
    if(self::$is_log_sql) 
    {
      self::$sql_logger = new CoreLogger_Sql();
    } else {
      self::$sql_logger = new CoreLogger_SqlEmpty();
    }
  }
  /**
   *
   * @param type $data
   * @param String $mode can be 'auto'  'file'  'output'
   */
  public static function dump($data, $mode = 'auto', $file = null)
  {
    if(Request::getExecutingMode() != Request::EXECUTE_MODE_CLI && ( $mode != 'file' && Core::getConfig('is_dev')) )
    {
      self::outputData($data);
    } else if($mode == 'file' || (Request::getExecutingMode() == Request::EXECUTE_MODE_CLI && $mode != 'output')) {
      self::saveToFile($data, $file);
    }   
  }
  /**
   * just outputs data
   *
   * @param type $data
   */
  public static function output($data)
  {
    self::dump($data, 'output');
  }
  
  public static function getDump()
  {
    return self::$variables_container;
  }
  
  public static function setVariablesOutput()
  {
    self::$variable_logging = self::VARIABLES_OUTPUT;
  }
  
  public static function setVariablesLogging()
  {
    self::$variable_logging = self::VARIABLES_LOGGER;
  }
  
  public static function sql_addQuery($query)
  {
    self::$sql_logger->addQuery($query);
  }
  
  public static function sql_getLog()
  {
    return self::$sql_logger->getLog();
  }
  
  public static function sql_start($query)
  {
    self::$sql_logger->start($query);
  }
  
  public static function sql_finish()
  {
    self::$sql_logger->finish();
  }
  
  public static function time($function, $times = 1000) 
  {
	  if($function instanceof Closure)
	  {
		  $func = $function;
	  } else {
		  $func = function () use($function) { eval($function); };
	  }
	  $time = microtime(true);
	  for($i=0; $i < $times; $i++)
	  {
		  $func();
	  }
	  self::dump('Execution time = ' . (microtime(true)-$time));
  }
  
  private static function outputData($data, $force_out = false)
  {
    ob_start();
    if(is_array($data) || is_object($data))
    {
      print_r($data);
    } else {
      var_dump($data);
    }
    $content = ob_get_clean();
    
    if(self::$variable_logging == self::VARIABLES_OUTPUT || $force_out)
    {
      echo $content;
    } else {
      self::$variables_container[] = $content;
    }
  }
  
  private static function saveToFile($data, $file = null)
  {
    ob_start();
    self::outputData($data, true);
    $content = ob_get_clean();
    
    if(!$file) $file = self::$log_file;
    $file = self::$log_path . $file;
    
    file_put_contents(
      $file, 
      "\n-----------------------------" . date('d.m.Y H:i:s') . "-----------------------------\n" . $content . "\n", 
      FILE_APPEND);
  }
}


?>
