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
  /**
   * is Logger needed
   *
   * @var Boolean 
   */
  private static $is_logger_enabled = true;
  
  private static $is_output_enabled = false;
  
  private static $is_file_logging_enabled = true;
  
  private static $log_file = 'logs/CoreLog';
  
  private static $is_day_logging = false;
  
  private static $is_log_sql = false;
 
  
  public static function __staticConstruct() {
    self::$is_log_sql = Core::getConfig('log_sql');
  }
  /**
   *
   * @param type $data
   * @param String $mode can be 'auto'  'file'  'output'
   */
  public static function dump($data, $mode = 'auto', $file = null)
  {
    if(Request::getExecutingMode() != Request::EXECUTE_MODE_CLI && $mode != 'file')
    {
      self::outputData($data);
    } else if($mode == 'file' || (Request::getExecutingMode() == Request::EXECUTE_MODE_CLI && $mode != 'output')) {
      ob_start();
      self::outputData($data);
      $content = ob_get_clean();
      self::saveToFile($content, $file);
    }
      
  }
  
  private static function outputData($data)
  {
    if(is_array($data) || is_object($data))
    {
      print_r($data);
    } else {
      var_dump($data);
    }
  }
  
  private static function saveToFile($content, $file = null)
  {
    if(!$file) $file = self::$log_file;
    if(self::$is_day_logging) $file .= '_' . date('Ymd');
    $file .= '.log';
    file_put_contents(
      $file, 
      "\n-----------------------------" . date('d.m.Y H:i:s') . "-----------------------------\n" . $content . "\n", 
      FILE_APPEND);
  }
}


?>
