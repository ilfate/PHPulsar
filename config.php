<?php


return array(

  'Service'  => '\Core\Service',
  'Response' => array(
    'abstract'      => '\Core\Response',
    'http'          => '\Core\Response\Http',
    'subquery'      => '\Core\Response\Http',
    'ajax'          => '\Core\Response\Ajax',
    'http_ajax'     => '\Core\Response\HttpAjax',
  ),
  'View'                       => array(
    'abstract'      => '\Core\View',
    'http'          => '\Core\View\Http',
    'http_ajax'     => '\Core\View\Http',
    'subquery'      => '\Core\View\Http',
  ),

  'log_sql'   => true,
  'is_dev'    => true,
  'logs_path' => '/home/ilfate/www/php/ilfate_php_engine/logs/',
  'site_url'  => 'php_engine.ru',
  'default_language' => 'EN',

  '\Core\Provider\PDOmysql' => array(
    'dbname' => 'ilfate',
    'host'   => 'localhost',
    'login'  => 'root',
    'pass'  =>  '',
  )
);