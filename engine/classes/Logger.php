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
  
  
  public static function dump($data)
  {
    if(is_array($data) || is_object($data))
	{
      print_r($data);
	} else {
      var_dump($data);
	}
	
  }
}


?>
