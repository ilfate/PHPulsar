<?php


return array(

  'Service'  => 'CoreService',
  'Response' => array(
    'abstract'      => 'CoreResponse',
    'http'          => 'CoreResponse_Http',
    'subquery'      => 'CoreResponse_Http',
    'ajax'          => 'CoreResponse_Ajax',
    'http_ajax'     => 'CoreResponse_HttpAjax',
  ),
  'View'                       => array(
    'abstract'      => 'CoreView',
    'http'          => 'CoreView_Http',
    'http_ajax'     => 'CoreView_Http',
    'subquery'      => 'CoreView_Http',
  ),

  'log_sql'   => true,
  'is_dev'    => true,
  'logs_path' => '/home/ilfate/www/php/ilfate_php_engine/logs/',
  'site_url'  => 'php_engine.ru',

  'CoreProvider_PDOmysql' => array(
    'dbname' => 'ilfate',
    'host'   => 'localhost',
    'login'  => 'root',
    'pass'  =>  '',
  )
);