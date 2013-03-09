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
   */
  public function __construct($result, CoreInterfaceView $view = null)
  {
    if (!is_array($result)) {
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
