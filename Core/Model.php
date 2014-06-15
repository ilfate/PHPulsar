<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

namespace Core;

use Core\Exception\ModelError;

/**
 * Description of CoreModel
 *
 * @author ilfate
 */
abstract class Model extends CachingClass
{

    /** @var AbstractFactory[]  */
    private static $instances = array();

    public static function getInstance()
    {
        $class = get_called_class();
        if (empty(self::$instances[$class])) {

            self::$instances[$class] = new $class();
        }
        return self::$instances[$class];
    }
    
    /**
     * obviosly Table name!
     *
     * @var String
     */
    public $table_name;

    /**
     * Here we got Primary Key!
     * It can be String or array('if there are', 'more then one field', 'in primary key')
     *
     * @var Mixed
     */
    public $primaryKey = 'id';

    public $provider_type = 'CoreProvider_PDOmysql';

    /** @var Provider */
    protected $provider;

    private $data;
    private $originData;

    /**
     *
     *
     * @param mixed $data
     * @param bool  $is_new_object if true passed data will not be saved as origin
     */
    public function __construct($data = null, $is_new_object = false)
    {
        $this->initProvider();
        $this->data = $data;
        if (!$is_new_object) {
            $this->originData = $data;
        }   
    }


    protected function initProvider()
    {
        if (!class_exists($this->provider_type)) {
            throw new ModelError('Cant init Model. "' . $this->provider_type . '" class is missing.');
        }
        $this->provider = forward_static_call(array($this->provider_type, 'getInstance'));
    }

    /**
     * One of the moust important Model functions.
     * It is actualy creates Model object and returns it.
     *
     * returns FLASE if coudnot find value
     *
     * @param Mixed $pk
     *
     * @return bool
     */
    public function getByPK($pk)
    {
        if (!is_array($this->primaryKey)) {
            // here all simple
            $where = '`' . $this->primaryKey . '` = ?';
            $pk    = $this->filter($pk);
        } else {
            // here we have complicated primaryKey
            $where = array_intersect_key($pk, array_flip($this->primaryKey));
            list($where, $params) = $this->getWhereStringAndParams($where);
        }
        $query = 'SELECT * FROM ' . $this->table_name . ' WHERE ' . $where;

        $data = $this->select($query, is_array($this->primaryKey) ? $params : array($pk));
        if ($data) {
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
     *
     * @return array
     */
    public function getRecord($where, $params = null)
    {
        list($where, $params) = $this->getWhereStringAndParams($where, $params);

        $query = 'SELECT * FROM ' . $this->table_name . ' WHERE ' . $where;
        $data  = $this->select($query, $params);
        if (isset($data[0])) {
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
     *
     * @return array
     */
    public function getList($where, $params = null)
    {
        list($where, $params) = $this->getWhereStringAndParams($where, $params);

        $query = 'SELECT * FROM ' . $this->table_name . ' WHERE ' . $where;
        $data  = $this->select($query, $params);

        return $this->createObjectList($data, get_called_class());
    }

    /**
     * Seme as ::getList() just returns only named fields for $fields array
     *
     * return array will be NOT assoc (coz we not sure is primaryKey field is returned)
     *
     * @param array $fields
     * @param mixed $where
     * @param array $params
     *
     * @return array
     */
    public function getFields($fields, $where, $params = null)
    {
        list($where, $params) = $this->getWhereStringAndParams($where, $params);
        $query = 'SELECT ' . $this->getFieldsString($fields) . ' FROM ' . $this->table_name . ' WHERE ' . $where;
        $data  = $this->select($query, $params);

        return $this->createObjectList($data, get_called_class(), false);
    }

    /**
     * This method returns onli one value that maches $where
     * (if there more then one mach the first one will be returned)
     *
     * @param String $field
     * @param Mixed  $where
     * @param array  $params
     *
     * @return String
     */
    public function getValue($field, $where, $params = null)
    {
        list($where, $params) = $this->getWhereStringAndParams($where, $params);
        $query = 'SELECT `' . $field . '` FROM ' . $this->table_name . ' WHERE ' . $where;
        $data  = $this->select($query, $params);
        if ($data && isset($data[0])) {
            return $data[0][$field];
        } else {
            return false;
        }
    }

    /**
     * this function just executes query and returns fetched result
     *
     * @param string $query
     * @param mixed  $params
     *
     * @return mixed
     */
    public function select($query, $params)
    {
        return $this->provider->fetch($query, $params);
        //return forward_static_call(array($this->provider_type, 'fetch'), $query, $params);
    }

    /**
     * this function just executes query and returns RAW result
     *
     * @param type $query
     * @param type $params
     *
     * @return type
     */
    public function execute($query, $params)
    {
        return $this->provider->execute($query, $params);
        //return forward_static_call(array($this->provider_type, 'execute'), $query, $params);
    }

    /**
     * returns last Insert Id !!
     *
     * @return integer
     */
    public function lastInsertId()
    {
        return $this->provider->lastInsertId();
        //return forward_static_call(array($this->provider_type, 'lastInsertId'));
    }

    /**
     * Filters any data
     *
     * @param mixed $data
     *
     * @return type
     */
    public function filter($data)
    {
        if (is_array($data)) {
            foreach ($data as &$str) {
                $str = $this->filter($str);
            }
            return $data;
        } else {
            return mysql_real_escape_string($data);
        }
    }

    public function __get($name)
    {
        if (isset($this->data[$name])) {
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
        if ($this->originData) {
            $new_data = array_diff_assoc($this->data, $this->originData);
            if (!is_array($this->primaryKey)) {
                // single field primaryKey
                $where = array($this->primaryKey => $this->data[$this->primaryKey]);
            } else { // multi field primaryKey
                $where = array();
                foreach ($this->primaryKey as $pk_field) {
                    $where[$pk_field] = $this->data[$pk_field];
                }
            }
            $this->update($new_data, $where);
        } else {
            $this->insert($this->data);
        }
    }

    /**
     * Updates row.
     * Where can be array. like array('id' => 5) ->> " where id = 5 "
     *
     * @param array $data
     * @param mixed $where
     */
    public function update(array $data, $where)
    {
        $set = array();
        foreach ($data as $key => $value) {
            $set[] = '`' . $key . '` = ' . (ctype_digit($value) ? '' : '"') . $value . (ctype_digit($value) ? '' : '"');
        }
        $set = implode(', ', $set);

        list($where, $params) = $this->getWhereStringAndParams($where);

        $query = 'UPDATE ' . $this->table_name . ' SET ' . $set . ' WHERE ' . $where;
        $this->execute($query, $params);
    }

    /**
     * Inserts that object into database
     *
     * @param array $data
     *
     * @return int
     */
    public function insert($data)
    {
        $fields_arr = array();
        $values_arr = array();
        $params     = array();
        foreach ($data as $key => $value) {
            $fields_arr[] = '`' . $key . '`';
            $values_arr[] = '?';
            $params[]     = $value;
        }
        $fields = implode(', ', $fields_arr);
        $values = implode(', ', $values_arr);
        $query  = 'INSERT INTO ' . $this->table_name . ' ( ' . $fields . ' ) VALUES ( ' . $values . ' ) ';
        $this->execute($query, $params);
        return $this->lastInsertId();
    }

    /**
     * returns data that represent this object as array
     *
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    protected function getWhereStringAndParams($data, $params = null)
    {
        if (is_array($data)) {
            $string_arr = array();
            $params     = array();
            foreach ($data as $key => $val) {
                $string_arr[] = '`' . $key . '` = ?';
                $params[]     = $val;
            }
            $where = implode(' AND ', $string_arr);
        } else {
            $where = $data;
        }
        return array($where, $params);
    }

    protected function getFieldsString(array $fields)
    {
        $fields_arr = array();
        foreach ($fields as $field) {
            $fields_arr[] = '`' . $field . '`';
        }
        $fields_string = implode(', ', $fields_arr);
        return $fields_string;
    }

    protected function createObjectList($data, $class, $is_assoc = true)
    {
        $return = array();
        if ($data) {
            foreach ($data as $row) {
                $obj = new $class($row);
                if ($is_assoc && !is_array($this->primaryKey) && isset($row[$this->primaryKey])) {
                    $return[$row[$this->primaryKey]] = $obj;
                } else {
                    $return[] = $obj;
                }
            }
        }
        return $return;
    }
}
