<?php
return array(
	'mandrill' => array(
		'apikey' => 'MANDRILL_API_TOKEN',
		'routes' => array(
			array(
				'route_url'   => '/mandrill/send',
				'route_types' => array('send'),
				'webhook_key' => '12345',
				'listener'    => array(
					'type' => 'event',
					'name' => 'myevent'
				),
				'verify_hook' => true
			),
			array(
				'route_url'   => '',
				'route_types' => array(''),
				'webhook_key' => '',
				'listener'    => array(
					'type' => 'queue',
					'name' => ''
				),
				'verify_hook' => false
			)
		)
	),
	'postmark' => array(
		'apikey' => 'POSTMARK_API_TEST'
	)
);