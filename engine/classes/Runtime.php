<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

/**
 * Description of CoreRuntime
 *
 * @author ilfate
 */
class CoreRuntime implements CoreInterfaceRuntime
{

  /**
   * array that keeps cookies for response
   *
   * @var array 
   */
  private static $cookies;
  /**
   * array that keeps headers for response
   *
   * @var array 
   */
  private static $headers;
  
  /**
	 * sets Cookie
	 *
	 * @param string $name Cookie name
	 * @param mixed $value value
	 * @param mixed $expire time
	 * @param string $path 
	 * @param string $domain 
	 * @param bool $secure 
	 * @param bool $httpOnly only HTTP
	 */
	public static function setCookie($name, $value, $expire = 0, $path = "/", $domain = "", $secure = false, $httpOnly = false) 
  {
		if ($expire !== null) {
			if (is_numeric($expire)) {
				$expire = (int) $expire;
			} else {
				$expire = strtotime($expire);
				if ($expire === false || $expire == -1) {
					$expire = 0;
				}
			}
		}

		self::$cookies[$name] = array(
			"name" => $name,
			"value" => $value,
			"expire" => $expire,
			"path" => $path,
			"domain" => $domain,
			"secure" => $secure ? true : false,
			"httpOnly" => $httpOnly,
		);
	}
  
  public static function getNewCookies()
  {
    return self::$cookies;
  }
  
  /**
	 * Sets HTTP-header
	 *
	 * @param string $name 
	 * @param mixed $value 
	 * @return bool
	 */
	public static function setHttpHeader($name, $value) {
		$name = self::normalizeHeaderName($name);

		if ($value === null) {
			unset(self::$headers[$name]);
			return;
		}

		self::$headers[$name] = $value;
	}
  
  
  private static function normalizeHeaderName($name) {
		return preg_replace("/\-(.)/e", "'-'.strtoupper('\\1')", strtr(ucfirst(strtolower($name)), "_", "-"));
	}
  
  public static function getNewHeaders()
  {
    return self::$headers;
  }
}


?>
