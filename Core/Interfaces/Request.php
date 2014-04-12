<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

namespace Core\Interfaces;

/**
 * Description of Request
 *
 * @author ilfate
 */
interface Request
{

    public function getPost();

    public function getGet();

    public function getExecutingMode();

    public function getValue($name);

    public function getSession($name);

    public function setSession($name, $value);

    public function deleteSession($name);

    public function getCookie($name);

}
