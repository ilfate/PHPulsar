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
class CoreResponse_Http extends CoreResponse 
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
   * @var string 
   */
  private $content;
  
  /**
   *
   * @var string 
   */
  private $layout = array();
  
  
  
  
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

    if(!$view)
    {
      throw new CoreException_ResponseHttpError('ResponseHttp needs View to build response');
    }
    $this->view = $view;
    if(!isset($result['tpl']))
    {
      $result['tpl'] = $this->getTemplateByRoute();
    }
    
    if(!isset($result['layout']))
    {
      if(Request::getExecutingMode() == Request::EXECUTE_MODE_HTTP)
      {
        $result['layout'] = $routing->getDefaultLayout();
      } else {
        $result['layout'] = array();
      }
    }
    
    $this->layout = $result['layout'];
    unset($result['layout']);
    $this->result = $result;
    
  }
  
  /**
   * If no template specified response will set default template for this action
   * 
   * @return type
   */
  private function getTemplateByRoute() 
  {
    return $this->routing->getClass() . '/' . $this->routing->getMethod() . '.' . CoreView_Http::TEMPLATE_FILE_EXTENSION;    
  }
  
  /**
   * returns content
   */
  public function getContent() 
  {
    if(!$this->content) 
    {
      $tpl = isset($this->result['tpl']) ? $this->result['tpl'] : '';
      $this->content = $this->view->render($tpl, $this->result, $this->layout);
    }
    return $this->content;
  }

  
  
  
}


?>
