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
class Core extends AbstractFactory
{

    public $engine_path = '/engine';
    public $app_path = '/app';
    public $modules_path = '/modules';

    /**
     * An Array of all inited Views
     * @var array
     */
    private $views;

    /**
     * shows is Core initialized
     * @var Boolean
     */
    private $inited = false;

    /**
     * keeps all initiaalized controllers
     *
     * @var array
     */
    private $stored_controllers = array();

    /** @var Logger */
    protected $log;

    /**
     * Core constructor
     */
    public function __construct()
    {
    }

    /*
     * here we start to build all we need for our engine
     */
    public function init()
    {
        if ($this->inited) {
            die("Fatal error. Attempt to init Core second time");
        }
        $this->inited = true;

        session_start();

        include ILFATE_PATH . 'Core/SplClassLoader.php';
        include ILFATE_PATH . 'Core/functions.php';
        //spl_autoload_register('ilfate_autoloader');
        $classLoader = new SplClassLoader('Core', ILFATE_PATH);
        $classLoader->register();
        $classLoader = new SplClassLoader('App', ILFATE_PATH);
        $classLoader->register();
        $classLoader = new SplClassLoader('Modules', ILFATE_PATH);
        $classLoader->register();

        // Here we create config object
        class_exists('\Core\Service');
        $config = Service::getConfig();
        $config->init(require ILFATE_PATH . 'config.php');

        $request = Service::getRequest();
        Service::getRouting($request);

        $this->log = Logger::getInstance();

        // depends on Mode we can different types of execution
        switch ($request->getExecutingMode()) {
            case Request::EXECUTE_MODE_HTTP :
                $this->commonExecuting();
            break;
            case Request::EXECUTE_MODE_HTTP_AJAX :
            case Request::EXECUTE_MODE_AJAX :
                $this->ajaxExecuting();
            break;
        }
    }

    /**
     * Normal executing
     */
    public function commonExecuting()
    {

        try {
            $frontController = Service::getFrontController();

            // define routing class and method
            $routing = Service::getRouting();
            $routing->execute();

            // here we execute services BEFORE main content
            $frontController->callPreExecution();

            $class    = $routing->getPrefixedClass();
            $method   = $routing->getMethod();
            $obj      = $this->getController($class);
            $response = $this->initResponse($obj->$method());

            Runtime::setHttpHeader("Content-Type", "text/html; charset=utf-8");
            $response->setHeaders();

            $this->output($response);
            // here we execute services AFTER main content
            $frontController->callPostExecution();
        } catch (\Exception $e) {
            $this->log->dump($e->getMessage(), 'file', 'CoreError.log');
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
    public function ajaxExecuting()
    {
        try {
            $frontController = Service::getFrontController();

            // define routing class and method
            $routing = Service::getRouting()->execute();

            // here we execute services BEFORE main content
            $frontController->callPreExecution();

            $class    = $routing->getPrefixedClass();
            $method   = $routing->getMethod();
            $obj      = $this->getController($class);
            $response = $this->initResponse($obj->$method());

            Runtime::setHttpHeader("Content-Type", "application/json; charset=utf-8");
            $response->setHeaders();

            $this->output($response);
            // here we execute services AFTER main content
            $frontController->callPostExecution();
        } catch (\Exception $e) {
            $this->log->dump($e->getMessage(), 'file', 'CoreError.log');
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
    public function subExecute($class, $method, $get, $post)
    {
        $request = Service::getRequest()->setFakeRequest($get, $post);
        $routing = Service::getRouting()->setFakeRouting($class, $method);

        $call_class  = $routing->getPrefixedClass();
        $call_method = $routing->getMethod();
        $obj         = $this->getController($call_class);
        $response    = $this->initResponse($obj->$call_method());

        $return = $this->output($response, true);

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
    public function output(Response $response, $returnString = false)
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
    public function initResponse($content)
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

        if (!isset($this->views[$mode])) {
            // if view is not inited we create it
            $view = $config->get('View');
            if (isset($view[$mode])) {
                $this->views[$mode] = new $view[$mode]();
            } else {
                $this->views[$mode] = null;
            }
        }

        return new $response[$mode]($content, $this->views[$mode]);
    }

    protected function getController($name)
    {
        if (!isset($this->stored_controllers[$name])) {
            // if need to, we create new one.
            $this->stored_controllers[$name] = new $name();
        }
        return $this->stored_controllers[$name];
    }
}
