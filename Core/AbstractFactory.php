<?php
/**
 * PHPulsar
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2014
 */


namespace Core;


abstract class AbstractFactory {
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
} 