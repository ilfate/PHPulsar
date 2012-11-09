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
  private static $PDOinstance;
	
  public function __construct() 
  {
	if(!class_exists('PDO'))
    {
      throw new CoreException_ModelError('PDO provider needs PDO class... surprise!');
	}
	try 
    {
      self::$PDOinstance = new PDO('mysql:dbname='.self::$dbname.';host='.self::$dbhost, self::$dblogin, self::$dbpass );
    }
    catch(PDOException $e)
    {
      throw new CoreException_ModelError('PDO coudnt connect to database. Check your config');
	}
  }
  
  public function fetch()
  {
    //запрос
	$source = $db->prepare(self::getQuery($lang));
	$source->execute();
	$data = array();
	while ($row = $source->fetch()) {
	  // Парсинг данных
	  self::parseRow($row, $data);
	}
  }
}


?>
