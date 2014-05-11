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
    /** @var  array */
    protected static $storage = array();

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
     * @var \App\Language
     */
    private static $language;

    private static function getting($name, $params = null)
    {
        if (empty(self::$storage[$name])) {
            $class_name = ucfirst($name);
            if (is_null($params)) {
                self::$storage[$name] = new $class_name();
            } elseif (count($params) == 1) {
                self::$storage[$name] = new $class_name($params[0]);
            } else {
                $reflection           = new \ReflectionClass($class_name);
                self::$storage[$name] = $reflection->newInstanceArgs($params);
            }
        }
        return self::$storage[$name];
    }

    /**
     * @return Config
     */
    public static function getConfig()
    {
        return self::getting('Core\Config');
    }

    /**
     * @return FrontController
     */
    public static function getFrontController()
    {
        return self::getting('Core\FrontController');
    }

    /**
     * @return Request
     */
    public static function getRequest()
    {
        return self::getting('Core\Request');
    }

    /**
     * @return Routing
     */
    public static function getRouting()
    {
        $params = func_get_args();
        return self::getting('Core\Routing', $params);
    }

    /**
     * @return \App\Language
     */
    public static function getLanguage()
    {
        return self::getting('App\Language');
    }

}