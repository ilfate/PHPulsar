<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

/**
 * Description of CoreModel
 *
 * @author ilfate
 */
abstract class CoreModel extends CoreCachingClass
{
  public static $table_name;
  
  public static $PK = 'id';
  
  public static $provider_type = 'CoreProvider_PDOmysql';
  
  public static $config_name = 'Config_DB';
  
  protected static $provider;
  
  public static function __staticConstruct()
  {
    self::initProvider();
  }
  
  protected static function initProvider()
  {
    if(!class_exists(self::$provider_type)) 
    {
      throw new CoreException_ModelError('Cant init Model. "'.self::$provider_type.'" class is missing.');
	}
	
	$config = new self::$config_name();
	
    self::$provider = new self::$provider_type();
  }
}


?>
