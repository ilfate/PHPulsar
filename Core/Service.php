<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2013
 */

namespace Core;

/**
 * Class Service
 * @package Core
 */
class Service
{

    /**
     * @var Config
     */
    private static $config;

    /**
     * @var FrontController
     */
    private static $frontController;

    /**
     * @var Request
     */
    private static $request;

    /**
     * @var Routing
     */
    private static $routing;

    /**
     * @var Language
     */
    private static $language;

    private static function getting($name, $params = null)
    {
        if (empty(self::$$name)) {
            $class_name = ucfirst($name);
            if (is_null($params)) {
                self::$$name = new $class_name();
            } elseif (count($params) == 1) {
                self::$$name = new $class_name($params[0]);
            } else {
                $reflection  = new \ReflectionClass($class_name);
                self::$$name = $reflection->newInstanceArgs($params);
            }
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

    /**
     * @return Request
     */
    public static function getRequest()
    {
        return self::getting('request');
    }

    /**
     * @return Routing
     */
    public static function getRouting()
    {
        $params = func_get_args();
        return self::getting('routing', $params);
    }

    /**
     * @return Language
     */
    public static function getLanguage()
    {
        return self::getting('language');
    }

}