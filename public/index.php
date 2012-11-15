<?php

// define http path to dir
$http_path = '/';
$path = realpath($_SERVER['DOCUMENT_ROOT']);
if (dirname(__FILE__) != $path && strpos($path, dirname(__FILE__)) === 0) {
	$http_path = str_replace(dirname(__FILE__), '', $path).'/';
}
$http_path = (strtoupper($_SERVER['SERVER_PROTOCOL'][5]) == 'S' ? 'https://' : 'http://')
	.$_SERVER['HTTP_HOST'].$http_path;
/**
 * Корневой HTTP путь
 * 
 * @var string
 */
define('HTTP_ROOT', $http_path);

unset($http_path, $path);

$paths = array(
    realpath(dirname(__FILE__) . '/../library'),
    '.',
	'/usr/lib/php5/'
);
set_include_path(implode(PATH_SEPARATOR, $paths));

include '../index.php';
