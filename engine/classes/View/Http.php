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
  
  private $layout = array();
  private $values = array();
  
  public function __construct() 
  {
  
  
  }
  
  

  public function render($template, $values, array $layout = array()) 
  {
    $values = array_merge(self::$global_values, $values);
    $this->values = $values;
    $this->layout = $layout;
    $file = self::TEMPLATE_PATH . $template;
    
    $this->checkFile($file);

    extract($values);
    ob_start();
    
    include $file;
    
    $html = ob_get_clean();
    
    if(!$this->layout)
    {
      return $html;
    } else {
      
      $layout_template = array_pop($this->layout);
      $this->values['content'] = $html;
      return $this->render($layout_template, $this->values, $this->layout);
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
      if(!file_exists($file)) 
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
  public function inc($template, $values)
  {
    return $this->render($template, $values);
  }
  
  
  public static function setGlobal($name, $value) 
  {
    self::$global_values[$name] = $value;
  }
}


?>
