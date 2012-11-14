<?php



return array(
  'project' => array(
    'main_path'                  => 'config.php',
    'engine_path'                => '/engine',
    'app_path'                   => '/app',
    'modules_path'               => '/modules', 
    'Service'                    => 'CoreService',
    'Response'                   => array(
      'abstract'      => 'CoreResponse',
      'http'          => 'CoreResponse_Http',
      'subquery'      => 'CoreResponse_Http'
		),
    'View'                       => array(
			'abstract'      => 'CoreView',
			'http'          => 'CoreView_Http',
			'subquery'      => 'CoreView_Http'
		),
      
    'log_sql' => true,
    'is_dev'  => false
      
  )
);