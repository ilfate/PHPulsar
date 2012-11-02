<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

/**
 * Description of CoreView_Http
 * 
 *
 * @author ilfate
 */
class CoreView_Http extends CoreView
{
	
  const TEMPLATE_FILE_EXTENSION = 'tpl';
  const TEMPLATE_PATH = 'app/tpl/';
	
 
  private $checked_files = array();
  
  public function __construct() 
  {
	
	
  }
  
  

  public function render($template, $values) 
  {
	$file = self::TEMPLATE_PATH . $template;
	$this->checkFile($file);
	
	extract($values);
	ob_start();
	
	include $file;
	
	$html = ob_get_clean();
	return $html;
  }
  
  /**
   * checks is file ok
   * 
   * @param String $file
   * @throws CoreException_ViewHttpError
   */
  private function checkFile($file) 
  {
	if(!isset($this->checked_files[$file]))
	{
	  if(!file_exists($file)) 
	  {
	    throw new CoreException_ViewHttpError('Can`t locate template file at ' . $file);
	  }  
	  $this->checked_files[$file] = true;
	}
  }
}


?>
