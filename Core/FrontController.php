<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

namespace Core;

/**
 * Description of CoreFrontController
 * This class finds all client`s frontControllers and executes them!
 *
 * @author ilfate
 */
class FrontController
{
    const PRIORITY = 1;

    const SERVICES_PREFIX = '\App\FrontController\\';
    const SERVICES_PATH   = 'App/FrontController/';

    const CACHE_KEY = 'CoreServiceExecutersList_Engine';

    /**
     * saved services
     *
     * @var \Core\Interfaces\FrontController[]
     */
    private $controllers;

    public function callPreExecution()
    {
        $services = $this->getControllers();
        foreach ($services as $service) {
            $service->preExecute();
        }
    }

    public function callPostExecution()
    {
        $services = $this->getControllers();
        foreach ($services as $service) {
            $service->postExecute();
        }
    }

    private function getControllers()
    {
        if (!$this->controllers) {
            $list = Service::getConfig()->get('list', 'frontController');
            foreach ($list as $name) {
                $class = self::SERVICES_PREFIX . $name;
                $this->controllers[] = new $class();
            }
        }
        return $this->controllers;
    }

}

