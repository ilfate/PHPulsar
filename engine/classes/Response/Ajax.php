<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

/**
 * Description of CoreResponse_Http
 * 
 *
 * @author ilfate
 */
class CoreResponse_Ajax extends CoreResponse 
{
      
  /**
   *
   * @var CoreInterfaceRouting 
   */
  private $routing;
  
  /**
   *
   * @var CoreInterfaceView 
   */
  private $view;
  
  /**
   *
   * @var array 
   */
  private $result;
    
  
  
  /**
   * 
   * @param array                    $result
   * @param CoreInterfaceRouting     $routing
   */
  public function __construct($result, CoreInterfaceRouting $routing, CoreInterfaceView $view = null) 
  {
    $this->routing = $routing;
    if(!is_array($result))
    {
      throw new CoreException_ResponseHttpError('Returned content of type Array expected');
    }
     
    $this->result = $result;
  }
  
  
  /**
   * returns content
   */
  public function getContent() 
  {
    return json_encode($this->result);
  }

  
  
}


?>
