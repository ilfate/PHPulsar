<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

namespace Core;

use Core\Exception\ConfigError;

/**
 * Class CoreConfig
 * A very good class! =)
 * Here we keep all main information
 * /app/config/config.*.php files can be accessed from here
 */
class Config
{

    protected $defaultConfig;

    const DEFAULT_TYPE = 'defaultConfig';
    const CONFIGS_PATH = 'App/config/';

    public function init($config)
    {
        if (!$this->defaultConfig) {
            $this->defaultConfig = $config;
        } else {
            throw new ConfigError('Here we got problems with attempt of second init');
        }
    }

    /**
     * Returns any data from config, just name the data you want
     * and which kind of data you want!
     *
     * @param $name
     * @param $type
     *
     * @throws ConfigError
     * @return null
     */
    public function get($name, $type = null)
    {
        if (is_null($type)) {
            $type = self::DEFAULT_TYPE;
        }

        if (empty($this->$type)) {
            $this->$type = require ILFATE_PATH . self::CONFIGS_PATH . 'config.' . $type . '.php';
            if (empty($this->$type)) {
                throw new ConfigError('One wants to get wrong Config type here...');
            }
        }
        $config = $this->$type;
        if (empty($config[$name])) {
            return null;
        }
        return $config[$name];
    }
}