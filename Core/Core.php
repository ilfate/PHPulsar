<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

namespace Core;

use Core\Exception\Error;
use Core\Interfaces\Response;

/**
 * Core engine class
 * we start our travel at here
 *
 * @author ilfate
 */
class Core
{

    public static $engine_path = '/engine';
    public static $app_path = '/app';
    public static $modules_path = '/modules';

    /**
     * An Array of all inited Views
     * @var array
     */
    private static $views;

    /**
     * shows is Core initialized
     * @var Boolean
     */
    private static $inited = false;

    /**
     * keeps all initiaalized controllers
     *
     * @var array
     */
    private static $stored_controllers = array();

    /**
     * we close it for singltone
     */
    private function __construct()
    {
        self::init();
    }

    /*
     * here we start to build all we need for our engine
     */
    public static function init()
    {
        if (self::$inited) {
            die("Fatal error. Attempt to init Core second time");
        }
        self::$inited = true;

        session_start();

        include ILFATE_PATH . '/Core/functions.php';
        spl_autoload_register('ilfate_autoloader');

        // Here we create config object
        class_exists('Service');
        $config = Service::getConfig();
        $config->init(require 'config.php');

        $request = Service::getRequest();
        Service::getRouting($request);

        // depends on Mode we can different types of execution
        switch ($request->getExecutingMode()) {
            case Request::EXECUTE_MODE_HTTP :
            {
                self::commonExecuting();
            }
                break;
            case Request::EXECUTE_MODE_HTTP_AJAX :
            case Request::EXECUTE_MODE_AJAX :
            {
                self::ajaxExecuting();
            }
                break;
        }
    }

    /**
     * Normal executing
     */
    public static function commonExecuting()
    {

        try {
            $frontController = Service::getFrontController();

            // define routing class and method
            $routing = Service::getRouting()->execute();

            // here we execute services BEFORE main content
            $frontController->callPreExecution();

            $class    = $routing->getPrefixedClass();
            $method   = $routing->getMethod();
            $obj      = self::getController($class);
            $response = Core::initResponse($obj->$method());

            Runtime::setHttpHeader("Content-Type", "text/html; charset=utf-8");
            $response->setHeaders();

            self::output($response);
            // here we execute services AFTER main content
            $frontController->callPostExecution();
        } catch (\Exception $e) {
            Logger::dump($e->getMessage(), 'file', 'CoreError.log');
            if (Service::getConfig()->get('is_dev')) {
                throw $e;
            } else {
                Helper::redirect('Error', 'page500');
            }
        }

    }

    /**
     * Ajax executing
     */
    public static function ajaxExecuting()
    {
        try {
            $frontController = Service::getFrontController();

            // define routing class and method
            $routing = Service::getRouting()->execute();

            // here we execute services BEFORE main content
            $frontController->callPreExecution();

            $class    = $routing->getPrefixedClass();
            $method   = $routing->getMethod();
            $obj      = self::getController($class);
            $response = Core::initResponse($obj->$method());

            Runtime::setHttpHeader("Content-Type", "application/json; charset=utf-8");
            $response->setHeaders();

            self::output($response);
            // here we execute services AFTER main content
            $frontController->callPostExecution();
        } catch (\Exception $e) {
            Logger::dump($e->getMessage(), 'file', 'CoreError.log');
            if (Service::getConfig()->get('is_dev')) {
                throw $e;
            } else {
                Helper::redirect('Error', 'page500');
            }
        }
    }

    /**
     * Creates new core execution ( like open link with another link )
     * And return result of this execution
     * instead of url we use here direct class and method names
     * it is just simplier and faster coz we dont need to use Routing
     *
     * @param string $class  Class name that we want to execute
     * @param string $method Method name that we want to excute
     * @param array  $get    Array with all get params that we want to pass to
     *                       that script. It will have its own GET array
     * @param array  $post   Array with all post params that we want to pass to
     *                       that script. It will have its own POST array
     *
     * @return string
     */
    public static function subExecute($class, $method, $get, $post)
    {
        $request = Service::getRequest()->setFakeRequest($get, $post);
        $routing = Service::getRouting()->setFakeRouting($class, $method);

        $call_class  = $routing->getPrefixedClass();
        $call_method = $routing->getMethod();
        $obj         = self::getController($call_class);
        $response    = Core::initResponse($obj->$call_method());

        $return = self::output($response, true);

        $routing->restoreRouting();
        $request->restoreRequest();
        return $return;
    }

    /**
     * This function takes response and flushs it
     *
     * @param Response $response
     * @param bool     $returnString
     *
     * @return
     */
    public static function output(Response $response, $returnString = false)
    {
        $content = $response->getContent();

        $headers = $response->setHeaders();

        if (!$returnString) {
            echo $content;
        } else {
            return $content;
        }
    }

    /**
     * Init and returns response object
     *
     * @param mixed $content
     *
     * @throws Exception\Error
     * @return
     */
    public static function initResponse($content)
    {
        if (is_array($content) && isset($content['mode'])) {
            // if mode is set by content
            $mode = $content['mode'];
        } else { // or we need to get current Mode
            $mode = Service::getRequest()->getExecutingMode();
        }

        $config   = Service::getConfig();
        $response = $config->get('Response');
        if (!isset($response[$mode])) {
            throw new Error('Cant find Response implementation class for "' . $mode . '" in config');
        }

        if (!isset(self::$views[$mode])) {
            // if view is not inited we create it
            $view = $config->get('View');
            if (isset($view[$mode])) {
                self::$views[$mode] = new $view[$mode]();
            } else {
                self::$views[$mode] = null;
            }
        }

        return new $response[$mode]($content, self::$views[$mode]);
    }

    protected static function getController($name)
    {
        if (!isset(self::$stored_controllers[$name])) {
            // if need to, we create new one.
            self::$stored_controllers[$name] = new $name();
        }
        return self::$stored_controllers[$name];
    }
}
