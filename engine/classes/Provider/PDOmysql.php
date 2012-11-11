<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

/**
 * Description of CoreProvider_PDOmysql
 *
 * @author ilfate
 */
class CoreProvider_PDOmysql extends CoreProvider
{
  /**
   *
   * @var PDO 
   */
  private static $PDO;
  private static $config;
  
  /**
	 * Default PDO options to set for each connection.
	 * @var array
	 */
	static $PDO_OPTIONS = array(
		PDO::ATTR_CASE => PDO::CASE_LOWER,
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL,
		PDO::ATTR_STRINGIFY_FETCHES => false
  );
  
  public function __staticConstruct() 
  {
    if(!class_exists('PDO'))
    {
      throw new CoreException_ModelError('PDO provider needs PDO class... surprise!');
    }
  }
  public static function init($config)
  {
    if($config) 
    {
      self::$config = $config;
    }
    try 
    {
      self::$PDO = new PDO(
        'mysql:dbname='.self::$config->dbname.';host='.self::$config->host, 
        self::$config->login, 
        self::$config->pass,
        static::$PDO_OPTIONS
      );
    } catch(PDOException $e) {
      throw new CoreException_ModelError(
        'PDO coudnt connect to database. Check your config. Ah yea and message was: "' . $e->getMessage(). '"'
      );
    }
  }
  
  public static function fetch($query, $params)
  {
    $source = self::$PDO->prepare($query);
    $source->execute($params);
    $data = $source->fetchAll(PDO::FETCH_ASSOC);
    return $data;
  }
  
  public static function execute($query, $params)
  {
    $source = self::$PDO->prepare($query);
    return $source->execute($params);
  }
  
  
  public function native_database_types()
	{
		return array(
			'primary_key' => 'int(11) UNSIGNED DEFAULT NULL auto_increment PRIMARY KEY',
			'string' => array('name' => 'varchar', 'length' => 255),
			'text' => array('name' => 'text'),
			'integer' => array('name' => 'int', 'length' => 11),
			'float' => array('name' => 'float'),
			'datetime' => array('name' => 'datetime'),
			'timestamp' => array('name' => 'datetime'),
			'time' => array('name' => 'time'),
			'date' => array('name' => 'date'),
			'binary' => array('name' => 'blob'),
			'boolean' => array('name' => 'tinyint', 'length' => 1)
		);
	}
}


?>
