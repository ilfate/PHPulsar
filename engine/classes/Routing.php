<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

/**
 * Description of CoreRouting
 *
 * @author ilfate
 */
class CoreRouting implements CoreInterfaceRouting{
  
  /**
   *
   * @var CoreInterfaceRequest 
   */
  private $request;
  
  public function __construct(CoreInterfaceRequest $request) {
    $this->request = $request;
  }

  public function getClass() {
    
  }

  public function getMethod() {
    
  }

  public function execute() {
    foreach ($this->request->getGet() as $var) {
      dump($var); echo '<br>';
    }
  }
  
  
  
  //put your code here
}

?>
