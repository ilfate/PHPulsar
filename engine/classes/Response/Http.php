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
	
  const TEMPLATE_FILE_EXTENSION = 'tpl';
	
  /**
   *
   * @var CoreInterfaceRouting 
   */
  private $routing;
  /**
   * 
   * @param type $result
   */
  public function __construct($result, CoreInterfaceRouting $routing) 
  {
	$this->routing = $routing;
	if(!is_array($result))
	{
	  throw new CoreException_ResponseHttpError('Returned content of type Array expected');
	}
	
	if(!isset($result['tpl']))
	{
	  $result['tpl'] = $this->getTemplateByRoute();
	}
	
	
  }
  
  /**
   * If no template specified response will set default template for this action
   * 
   * @return type
   */
  private function getTemplateByRoute() 
  {
    return $this->routing->getClass() . '/' . $this->routing->getMethod() . '.' . self::TEMPLATE_FILE_EXTENSION;	  
  }
}


?>
