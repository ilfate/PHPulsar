<?php

$local_configuration = include('local_config.php');

return array(
  'project' => array(
    'Service'                    => 'CoreService',
    'Response'                   => array(
      'abstract'      => 'CoreResponse',
      'http'          => 'CoreResponse_Http',
      'subquery'      => 'CoreResponse_Http',
      'ajax'          => 'CoreResponse_HttpAjax',
		),
    'View'                       => array(
			'abstract'      => 'CoreView',
			'http'          => 'CoreView_Http',
			'subquery'      => 'CoreView_Http',
		),
      
    'log_sql' => $local_configuration['project']['log_sql'],
    'is_dev'  => $local_configuration['project']['is_dev']
      
  ),
  'CoreProvider_PDOmysql' => array(
	'dbname' => 'ilfate',
	'host'   => 'localhost',
	'login'  => 'root',
	'pass'  =>  $local_configuration['CoreProvider_PDOmysql']['pass'],
  )
);