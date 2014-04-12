<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

namespace Core\Interfaces;
/**
 * Description of Runtime
 *
 * @author ilfate
 */
interface Runtime
{
    public static function setCookie(
        $name,
        $value,
        $expire = null,
        $path = "/",
        $domain = "",
        $secure = false,
        $httpOnly = false
    );

    public static function getNewCookies();
}

?>
