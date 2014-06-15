<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

namespace Core\Provider;

use Core\Exception\ModelError;
use Core\Logger;
use Core\Provider;
use Core\Service;

/**
 * Description of CoreProvider_PDOmysql
 *
 * @author ilfate
 */
class PDOmysql extends Provider
{
    /**
     *
     * @var \PDO
     */
    private $PDO;
    private $config;
    
    /** @var Logger */
    protected $log;

    /**
     * Default PDO options to set for each connection.
     * @var array
     */
    static $PDO_OPTIONS = array(
        \PDO::ATTR_CASE              => \PDO::CASE_LOWER,
        \PDO::ATTR_ERRMODE           => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_ORACLE_NULLS      => \PDO::NULL_NATURAL,
        \PDO::ATTR_STRINGIFY_FETCHES => false
    );

    public function __construct()
    {
        $this->log = Logger::getInstance();
        $this->init();
    }

    public function init()
    {
        if (!class_exists('PDO')) {
            throw new ModelError('PDO provider needs PDO class... surprise!');
        }
        
        $this->config = Service::getConfig()->get('CoreProvider_PDOmysql');

        try {
            $this->PDO = new \PDO(
                'mysql:dbname=' . $this->config['dbname'] . ';host=' . $this->config['host'],
                $this->config['login'],
                $this->config['pass'],
                static::$PDO_OPTIONS
            );
        } catch (\PDOException $e) {
            throw new ModelError(
                'PDO coudnt connect to database. Check your config. Ah yea and message was: "' . $e->getMessage() . '"'
            );
        }
    }

    public function fetch($query, $params)
    {
        $this->log->sql_start($query);
        $source = $this->PDO->prepare($query);
        $source->execute($params);
        $data = $source->fetchAll(\PDO::FETCH_ASSOC);
        $this->log->sql_finish();
        return $data;
    }

    public function execute($query, $params)
    {
        $this->log->sql_start($query);
        $source = $this->PDO->prepare($query);
        $data   = $source->execute($params);
        $this->log->sql_finish();
        if ($data) {
            return $source->rowCount();
        } else {
            return false;
        }
    }

    /**
     * @return int
     */
    public function lastInsertId()
    {
        return $this->PDO->lastInsertId();
    }

    public function native_database_types()
    {
        return array(
            'primary_key' => 'int(11) UNSIGNED DEFAULT NULL auto_increment PRIMARY KEY',
            'string'      => array('name' => 'varchar', 'length' => 255),
            'text'        => array('name' => 'text'),
            'integer'     => array('name' => 'int', 'length' => 11),
            'float'       => array('name' => 'float'),
            'datetime'    => array('name' => 'datetime'),
            'timestamp'   => array('name' => 'datetime'),
            'time'        => array('name' => 'time'),
            'date'        => array('name' => 'date'),
            'binary'      => array('name' => 'blob'),
            'boolean'     => array('name' => 'tinyint', 'length' => 1)
        );
    }
}
