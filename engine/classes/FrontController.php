<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

/**
 * Description of CoreFrontController
 * This class finds all client`s frontControllers and executes them!
 *
 * @author ilfate
 */
class CoreFrontController
{
  const PRIORITY        = 1;
  
  const SERVICES_PREFIX = 'FrontController_';
  const SERVICES_PATH   = 'app/classes/FrontController/';
  
  const CACHE_KEY       = 'CoreServiceExecutersList_Engine';
  
  /**
   * saved services
   * 
   * @var array
   */
  private $controllers;


  public function callPreExecution()
  {
    $services = $this->getControllers();
    foreach ($services as $service)
    {
      
      $service::preExecute();
    }
  }
  
  public function callPostExecution()
  {
    $services = $this->getControllers();
    foreach ($services as $service)
    {
      $service::postExecute();
    }
  }
  
  
  private function getControllers()
  {
    if(!$this->controllers)
    {
      $list = Service::getConfig()->get('list', 'frontController');
      foreach ($list as $name) {
        $this->controllers[] = self::SERVICES_PREFIX . $name;
      }

//      class_exists('Cache');
//      $cached = Cache::get(self::CACHE_KEY);
//      if(!$cached) {
//        $iterator = new GlobIterator(ILFATE_PATH . self::SERVICES_PATH . '*.php');
//        $filelist = array();
//        foreach($iterator as $entry)
//        {
//          $name = self::SERVICES_PREFIX . substr($entry->getFilename(), 0, -4);
//          $filelist[$name] = $name::PRIORITY;
//          // keys are names and values are priority indexs for sorting
//        }
//        asort($filelist);
//
//        $this->controllers = array_keys($filelist);
//        Cache::set(self::CACHE_KEY, $this->controllers, 36000);
//      } else {
//        $this->controllers = $cached;
//      }
    }
    return $this->controllers;
  }
    

  
}


?>
