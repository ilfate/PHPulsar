<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

namespace Modules;

use Core\Exception\Error;
use Core\Exception\RoutingError;
use Core\Service;

/**
 * Description of ModuleRouting
 *
 * @author ilfate
 */
class Routing extends \Core\Routing
{
    /**
     * Main executing method.
     * Will find a class and method for execution
     *
     * Try to perform some layers
     *
     * @throws RoutingError
     */
    public function execute()
    {
        $uri     = Service::getRequest()->getDocUri();
        $uri_arr = array_values(array_filter(explode('/', $uri)));
        $arr_len = sizeof($uri_arr);
        if ($arr_len >= 2) {
            $class  = implode('_', array_slice($uri_arr, 0, -1));
            $method = $uri_arr[$arr_len - 1];
        } else {
            if ($arr_len == 1) {
                $class = $uri_arr[0];
            } else {
                $class = self::DEFAULT_CLASS;
            }
            $method = self::DEFAULT_METHOD;
        }

        $prefixed_class = self::CLASS_PREFIX . $class;

        try { // here we try to force out autoloader.
            // If there is no such class we will catch exception about it
            class_exists($prefixed_class);
        } catch (Error $e) {
            throw new RoutingError('Cant find route for "' . $class . '". Possible problem: ' . $e->getMessage());
        }

        if (!method_exists($prefixed_class, $method) && !method_exists($prefixed_class, '_' . $method)) {
            throw new RoutingError('Cant find method for "' . $class . '" -> "' . $method . '"');
        }

        $this->class  = $class;
        $this->method = $method;
        return $this;
    }

    /**
     * Revers routing. Creates url from Class and Method
     *
     * @param string $class
     * @param string $method
     *
     * @return string
     */
    public function getUrl($class, $method)
    {
        if (strpos($class, '_') !== false) {
            $class_str = str_replace('_', '/', $class);
        } else {
            $class_str = $class;
        }
        return '/' . $class_str . '/' . $method;
    }
}
