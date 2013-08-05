<?php
return array(
	'mandrill' => array(
		'apikey'    => 'MANDRILL_API_TOKEN',
		'web_hooks' => array(
			'enabled' => false,
			'routes'  => array(
				array(
					'route_url'   => '/mandrill/send',
					'route_types' => array('send'),
					'webhook_key' => 'API_WEBHOOK_KEY',
					'listener'    => array(
						'type' => 'event',
						'name' => ''
					),
					'verify_hook' => false
				),
				array(
					'route_url'   => '/mandrill/bounce',
					'route_types' => array(''),
					'webhook_key' => '',
					'listener'    => array(
						'type' => 'queue',
						'name' => ''
					),
					'verify_hook' => false
				)
			)
		)
	),
	'postmark' => array(
		'apikey' => 'POSTMARK_API_TEST'
	)
);