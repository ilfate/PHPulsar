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
  /**
   * obviosly Table name!
   *
   * @var String
   */
  public static $table_name;
  
  /**
   * Here we got Primary Key! 
   * It can be String or array('if there are', 'more then one field', 'in primary key')
   *
   * @var Mixed 
   */
  public static $PK = 'id';
  
  public static $provider_type = 'CoreProvider_PDOmysql';
  
  private $data;
  private $origin_data;
  
  /**
   * 
   *
   * @param type $data
   * @param type $is_new_object if true passed data will not be saved as origin
   */
  public function __construct($data, $is_new_object = false) {
    $this->data = $data;
    if(!$is_new_object)
    {
      $this->origin_data = $data;
    }
  }
  /**
   * Our static constructor will init for us that connection. 
   */
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
  
  
    forward_static_call(array(self::$provider_type, 'init'));
  }
  
  /**
   * One of the moust important Model functions. 
   * It is actualy creates Model object and returns it.
   * 
   * returns FLASE if coudnot find value
   * 
   * @param Mixed $pk 
   */
  public static function getByPK($pk)
  {
    if(!is_array(self::$PK)) // here all simple
    {
      $where = '`' . static::$PK .'` = ?';
      $pk = self::filter($pk);
    } else {
      // here we have complicated PK
      $where = array_intersect_key($pk, array_flip(static::$PK));
      list($where, $params) = self::getWhereStringAndParams($where);
    }
    $query = 'SELECT * FROM ' . static::$table_name . ' WHERE ' . $where;
    
    $data = self::select($query, is_array(static::$PK)?$params:array($pk));
    if($data)
    {
      $class = get_called_class();
      return new $class($data[0]);
    } else {
      return false;
    }
  }
  
  /**
   * This method creates single model object 
   * If there more then one object will return first one
   * Where can be: array('name' => 'ilfate') --> " WHERE `name` = 'ilfate' "
   * 
   * @param mixed $where
   * @param array $params
   * @return array 
   */
  public static function getRecord($where, $params = null)
  {
    list($where, $params) = self::getWhereStringAndParams($where, $params);
    
    $query = 'SELECT * FROM ' .static::$table_name . ' WHERE '. $where;
    $data = self::select($query, $params);
    if(isset($data[0]))
    {
      $class = get_called_class();
      return new $class($data[0]);
    } else {
      return false;
    }
      
  }
  
  /**
   * This method creates array of model objects that are will be found by where case
   * Where can be: array('name' => 'ilfate') --> " WHERE `name` = 'ilfate' "
   * 
   * @param mixed $where
   * @param array $params
   * @return array 
   */
  public static function getList($where, $params = null)
  {
    list($where, $params) = self::getWhereStringAndParams($where, $params);
    
    $query = 'SELECT * FROM ' .static::$table_name . ' WHERE '. $where;
    $data = self::select($query, $params);
    
    return self::createObjectList($data, get_called_class());
  }
  
  
  /**
   * Seme as ::getList() just returns only named fields for $fields array
   * 
   * return array will be NOT assoc (coz we not sure is PK field is returned)
   * 
   * @param array $fields
   * @param mixed $where
   * @param array $params
   * @return array 
   */
  public static function getFields($fields, $where, $params = null)
  {
    list($where, $params) = self::getWhereStringAndParams($where, $params);    
    $query = 'SELECT ' . self::getFieldsString($fields) . ' FROM ' .static::$table_name . ' WHERE '. $where;
    $data = self::select($query, $params);
    
    return self::createObjectList($data, get_called_class(), false);
  }
  
  
  /**
   * This method returns onli one value that maches $where 
   * (if there more then one mach the first one will be returned)
   * 
   * @param String $field
   * @param Mixed $where
   * @param array $params
   * @return String 
   */
  public static function getValue($field, $where, $params = null)
  {
    list($where, $params) = self::getWhereStringAndParams($where, $params);    
    $query = 'SELECT `' . $field . '` FROM ' .static::$table_name . ' WHERE '. $where;
    $data = self::select($query, $params);
    if($data && isset($data[0])) {
    return $data[0][$field];
  } else {
    return false;
  }
  }
  
  /**
   * this function just executes query and returns fetched result
   *
   * @param type $query
   * @param type $params
   * @return type 
   */
  public static function select($query, $params)
  {
    return forward_static_call(array(self::$provider_type, 'fetch'), $query, $params);
  }
  
  /**
   * this function just executes query and returns RAW result
   *
   * @param type $query
   * @param type $params
   * @return type 
   */
  public static function execute($query, $params)
  {
    return forward_static_call(array(self::$provider_type, 'execute'), $query, $params);
  }
  
  /**
   * returns last Insert Id !!
   *
   * @return integer
   */
  public static function lastInsertId()
  {
    return forward_static_call(array(self::$provider_type, 'lastInsertId'));
  }
  
  /**
   * Filters any data
   * 
   * @param mixed $data
   * @return type 
   */
  public static function filter($data)
  {
    if(is_array($data)) 
    {
      foreach ($data as &$str)
      {
        $str = self::filter($str);
      }
      return $data;
    } else {
      return mysql_real_escape_string($data);
    }
  }
  
  public function __get($name) {
    if(isset($this->data[$name]))
    {
      return $this->data[$name];
    } else {
      return null;
    }
  }
  
  public function __isset($name) 
  {
    return isset($this->data[$name]);
  }
  
  public function __set($name, $value) 
  {
    $this->data[$name] = $value;
  }
  
  public function save()
  {
    if($this->origin_data)
    {
      $new_data = array_diff_assoc($this->data, $this->origin_data);
      if(!is_array(static::$PK))
      {       // single field PK
        $where = array(static::$PK => $this->data[static::$PK]);
      } else {  // multi field PK
        $where = array();
        foreach (static::$PK as $pk_field)
        {
          $where[$pk_field] = $this->data[$pk_field];
        }
      }
      self::update($new_data, $where);
    } else {
      self::insert($this->data);
    }
  }
  
  /**
   * Updates row.
   * Where can be array. like array('id' => 5) ->> " where id = 5 "
   * 
   * @param array $data
   * @param mixed $where 
   */
  public static function update(array $data, $where)
  {
    $set = array();
    foreach ($data as $key => $value)
    {
      $set[] = '`' . $key . '` = ' . (ctype_digit($value)?'':'"') . $value . (ctype_digit($value)?'':'"');
    }
    $set = implode(', ', $set);
    
    list($where, $params) = self::getWhereStringAndParams($where);
    
    $query = 'UPDATE ' . static::$table_name . ' SET '. $set .' WHERE ' . $where;
    self::execute($query, $params);
  }
  
  /**
   * Inserts that object into database
   * 
   * @param array $data 
   */
  public static function insert($data) 
  {
    $fields_arr = array();
    $values_arr = array();
    $params = array();
    foreach ($data as $key => $value)
    {
      $fields_arr[] = '`' . $key . '`';
      $values_arr[] = '?';
      $params[] = $value;
    }
    $fields = implode(', ', $fields_arr);
    $values = implode(', ', $values_arr);
    $query = 'INSERT INTO ' . static::$table_name . ' ( ' . $fields . ' ) VALUES ( ' . $values . ' ) ';
    self::execute($query, $params);
    return self::lastInsertId();
  }
  
  /**
   * returns data that represent this object as array
   *
   * @return type 
   */
  public function toArray()
  {
    return $this->data;
  }
  
  protected static function getWhereStringAndParams($data, $params = null)
  {
    if(is_array($data))
    {
      $string_arr = array();
      $params = array();
      foreach ($data as $key => $val)
      {
        $string_arr[] = '`' . $key . '` = ?';
        $params[] = $val;
      }
      $where = implode(' AND ', $string_arr);
    } else {
      $where = $data;
    }
    return array($where, $params);
  }
  
  protected static function getFieldsString(array $fields)
  {
    $fields_arr = array();
    foreach ($fields as $field)
    {
      $fields_arr[] = '`' .$field . '`';
    }
    $fields_string = implode(', ', $fields_arr);
    return $fields_string;
  }
  
  protected static function createObjectList($data, $class, $is_assoc = true)
  {
    $return = array();
    if($data)
    {
      foreach ($data as $row) 
      {
        $obj = new $class($row);
        if($is_assoc && !is_array(static::$PK) && isset($row[static::$PK]))
        {
          $return[$row[static::$PK]] = $obj;
        } else {
          $return[] = $obj;
        }
      }
    }
    return $return;
  }
}


?>
