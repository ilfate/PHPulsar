<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2013
 */


class CoreService
{

  /**
   * @var Config
   */
  private static $config;

  /**
   * @var FrontController
   */
  private static $frontController;




  private static function getting($name)
  {
    if(empty(self::$$name)) {
      $class_name = ucfirst($name);
      self::$$name = new $class_name();
    }
    return self::$$name;
  }

  /**
   * @return Config
   */
  public static function getConfig()
  {
    return self::getting('config');
  }

  /**
   * @return FrontController
   */
  public static function getFrontController()
  {
    return self::getting('frontController');
  }

}