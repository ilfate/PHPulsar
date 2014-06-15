<?php

/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */


if (version_compare(phpversion(), '5.3', '<') == true) {
	die("requires PHP 5.3.x");
}

$pulsarPath = strpos(__DIR__, '/public') !== false ? substr(__DIR__, 0, -7) : __DIR__;
define('ILFATE_PATH', $pulsarPath . '/');

define('SERVER_NAME', $_SERVER['SERVER_NAME']);

if(!defined('HTTP_ROOT')) 
{
	$http_path = '/';
	$path = realpath($_SERVER['DOCUMENT_ROOT']);
	if (dirname(__FILE__) != $path && strpos($path, dirname(__FILE__)) === 0) {
		$http_path = str_replace(dirname(__FILE__), '', $path).'/';	
	} 
	$http_path = (strtoupper($_SERVER['SERVER_PROTOCOL'][5]) == 'S' ? 'https://' : 'http://')
		.$_SERVER['HTTP_HOST'].$http_path;
	
	define('HTTP_ROOT',   $http_path);

	unset($http_path, $path);
}

// include main engine class
require '../Core/AbstractFactory.php';
require '../Core/Core.php';
// and initialize it
/** @var Core\Core $core */
$core = Core\Core::getInstance();
$core->init();




