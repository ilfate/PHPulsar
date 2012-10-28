<?php

/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */


if (version_compare(phpversion(), '5.3', '<') == true) {
	die("requires PHP 5.3.x");
}

define('ILFATE_PATH', __DIR__);

require 'engine/classes/Core.php';
Core::init();





