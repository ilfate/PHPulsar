<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

/**
 * Class CoreConfig
 * A very good class! =)
 * Here we keep all main information
 * /app/config/config.*.php files can be accessed from here
 */
class CoreConfig {

  protected $defaultConfig;


  const DEFAULT_TYPE = 'defaultConfig';
  const CONFIGS_PATH = 'app/config/';

  public function init($config)
  {
    if (!$this->defaultConfig) {
      $this->defaultConfig = $config;
    } else {
      throw new CoreException_ConfigError('Here we got problems with attempt of second init');
    }
  }

  /**
   * Returns any data from config, just name the data you want
   * and which kind of data you want!
   * @param $name
   * @param $type
   */
  public function get($name, $type = null)
  {
    if (is_null($type)) {
      $type = self::DEFAULT_TYPE;
    }

    if (empty($this->$type)) {
      $this->$type = require self::CONFIGS_PATH . 'config.' . $type . '.php';
      if (empty($this->$type)) {
        throw new CoreException_ConfigError('One wants to get wrong Config type here...');
      }
    }
    $config = $this->$type;
    if (empty($config[$name])) {
      return null;
    }
    return $config[$name];
  }
}