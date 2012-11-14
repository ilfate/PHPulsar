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
  
  static protected $statusTexts = array(
		"100" => "Continue",
		"101" => "Switching Protocols",
		"200" => "OK",
		"201" => "Created",
		"202" => "Accepted",
		"203" => "Non-Authoritative Information",
		"204" => "No Content",
		"205" => "Reset Content",
		"206" => "Partial Content",
		"300" => "Multiple Choices",
		"301" => "Moved Permanently",
		"302" => "Found",
		"303" => "See Other",
		"304" => "Not Modified",
		"305" => "Use Proxy",
		"306" => "(Unused)",
		"307" => "Temporary Redirect",
		"400" => "Bad Request",
		"401" => "Unauthorized",
		"402" => "Payment Required",
		"403" => "Forbidden",
		"404" => "Not Found",
		"405" => "Method Not Allowed",
		"406" => "Not Acceptable",
		"407" => "Proxy Authentication Required",
		"408" => "Request Timeout",
		"409" => "Conflict",
		"410" => "Gone",
		"411" => "Length Required",
		"412" => "Precondition Failed",
		"413" => "Request Entity Too Large",
		"414" => "Request-URI Too Long",
		"415" => "Unsupported Media Type",
		"416" => "Requested Range Not Satisfiable",
		"417" => "Expectation Failed",
		"500" => "Internal Server Error",
		"501" => "Not Implemented",
		"502" => "Bad Gateway",
		"503" => "Service Unavailable",
		"504" => "Gateway Timeout",
		"505" => "HTTP Version Not Supported",
	);
    
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
   * @var array 
   */
  private $headers = array();
  
  private $statusCode = 200;
  
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

  public function setHeaders() {
    $protocol = isset($_SERVER["SERVER_PROTOCOL"]) ? $_SERVER["SERVER_PROTOCOL"] : "HTTP/1.0";
		header($protocol . " " . $this->statusCode . " " . self::$statusTexts[$this->statusCode]);
    
    $mode = Request::getExecutingMode();
    switch ($mode) 
    {
      case Request::EXECUTE_MODE_HTTP : 
      {
          Runtime::setHttpHeader("Content-Type", "text/html; charset=utf-8");
      } break; 
    }

    $headers = Runtime::getNewHeaders();
    if($headers)
    {
      foreach ($headers as $name => $value) 
      {
        header($name . ": " . $value);
      }
    }
    $cookies = Runtime::getNewCookies();
    if($cookies)
    {
      foreach ($cookies as $cookie) 
      {
        setrawcookie($cookie["name"], $cookie["value"], $cookie["expire"], $cookie["path"], $cookie["domain"], $cookie["secure"], $cookie["httpOnly"]);
      }
    }
    
    return $headers;
  }
  
  
}


?>
