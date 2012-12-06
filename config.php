<?php


return array(
  'project' => array(
    'Service'                    => 'CoreService',
    'Response'                   => array(
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
      
    'log_sql' => true,
    'is_dev'  => false,
    'logs_path' => '/home/ilfate/www/php/logs/'
      
  ),
  'CoreProvider_PDOmysql' => array(
	'dbname' => 'ilfate',
	'host'   => 'localhost',
	'login'  => 'root',
	'pass'  =>  '',
  )
);