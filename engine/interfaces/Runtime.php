<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

/**
 * Description of Runtime
 *
 * @author ilfate
 */
interface CoreInterfaceRuntime
{
  public static function setCookie($name, $value, $expire = null, $path = "/", $domain = "", $secure = false, $httpOnly = false);
  public static function getNewCookies();
}

?>
