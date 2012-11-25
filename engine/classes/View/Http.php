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
  
  private static $global_values = array();


  private $checked_files = array();
  
  public function __construct() 
  {
  
  
  }
  
  
  /**
   * Renders a themplate
   * 
   * @param string $template
   * @param array $values
   * @param array $layout
   * @return type 
   */
  public function render($render__template, $render__values = array(), array $render__layout = array()) 
  {
    $render__merged_values = array_merge(self::$global_values, $render__values);
    $render__file = self::TEMPLATE_PATH . $render__template;
    
    $this->checkFile($render__file);

    extract($render__merged_values);
    ob_start();
    
    require ILFATE_PATH . $render__file;
    
    $html = ob_get_clean();
    
    if(!$render__layout)
    {
      return $html;
    } else {
      
      $layout_template = array_pop($render__layout);
      $render__values['content'] = $html;
      return $this->render($layout_template, $render__values, $render__layout);
    }
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
      if(!file_exists(ILFATE_PATH . $file)) 
      {
        throw new CoreException_ViewHttpError('Can`t locate template file at ' . $file);
      }  
      $this->checked_files[$file] = true;
    }
  }
  
  /**
   * Alternative name for render
   * 
   * @param type $template
   * @param type $values
   * @return type 
   */
  public function inc($template, $values = array())
  {
    return $this->render($template, $values);
  }
  
  
  public static function setGlobal($name, $value) 
  {
    self::$global_values[$name] = $value;
  }
}


?>
