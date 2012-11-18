<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

/**
 * Description of CoreResponse
 *
 * @author ilfate
 */
abstract class CoreResponse implements CoreInterfaceResponse
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
   * @var array 
   */
  protected $headers = array();
  
  protected $statusCode = 200;
  
  
  
  public function setHeaders() {
    $protocol = isset($_SERVER["SERVER_PROTOCOL"]) ? $_SERVER["SERVER_PROTOCOL"] : "HTTP/1.0";
		header($protocol . " " . $this->statusCode . " " . self::$statusTexts[$this->statusCode]);
    
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
