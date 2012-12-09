<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

/**
 * Description of CoreService
 *
 * @author ilfate
 */
class CoreServiceExecuter implements CoreInterfaceServiceExecuter
{
  const PRIORITY        = 1;
  
  const SERVICES_PREFIX = 'Service_';
  const SERVICES_PATH   = 'app/classes/Service/';
  
  const CACHE_KEY       = 'CoreServiceExecutersList_Engine';
  
  /**
   * saved services
   * 
   * @var array
   */
  private $services;


  public function callPreServices() 
  {
    $services = $this->getServices();
    foreach ($services as $service)
    {
      
      $service::preExecute();
    }
  }
  
  public function callPostServices() 
  {
    $services = $this->getServices();
    foreach ($services as $service)
    {
      $service::postExecute();
    }
  }
  
  
  private function getServices() 
  {
    if(!$this->services)
    {
      class_exists('Cache');
      $cached = Cache::get(self::CACHE_KEY);
      if(!$cached) {
        $iterator = new GlobIterator(ILFATE_PATH . self::SERVICES_PATH . '*.php');
        $filelist = array();
        foreach($iterator as $entry) 
        {
          $name = self::SERVICES_PREFIX . substr($entry->getFilename(), 0, -4);
          $filelist[$name] = $name::PRIORITY;
          // keys are names and values are priority indexs for sorting
        }
        asort($filelist);

        $this->services = array_keys($filelist);
        Cache::set(self::CACHE_KEY, $this->services, 36000);
      } else {
        $this->services = $cached;
      }
    }
    return $this->services;
  }
    

  
}


?>
