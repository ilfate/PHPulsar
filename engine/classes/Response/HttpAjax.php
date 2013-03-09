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
class CoreResponse_HttpAjax extends CoreResponse 
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
   * @var string 
   */
  private $content;
  
  
  /**
   * 
   * @param array                    $result
   */
  public function __construct($result, CoreInterfaceView $view = null)
  {
    if (!is_array($result)) {
      throw new CoreException_ResponseHttpError('Returned content of type Array expected');
    }
	  $this->view = $view;
    $this->result = $result;
  }

  /**
   * returns content
   */
  public function getContent() 
  {
    if (!$this->content) {
      $tpl = isset($this->result['tpl']) ? $this->result['tpl'] : '';
      $this->content = $this->view->render($tpl, $this->result, array());
    }
    return $this->content;
  }
}

