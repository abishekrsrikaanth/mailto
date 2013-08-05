<?php
return array(
	/*
    |--------------------------------------------------------------------------
    | Mandrill
    |--------------------------------------------------------------------------
    |
    | The configuration for handling all mandrill related implementation
    |
    */
	'mandrill' => array(
		/*
	    |--------------------------------------------------------------------------
	    | API Key
	    |--------------------------------------------------------------------------
	    |
		| The API Credential of Mandrill
	    |
	    */
		'apikey'    => 'MANDRILL_API_TOKEN',
		/*
	    |--------------------------------------------------------------------------
	    | Web Hook Configuration
	    |--------------------------------------------------------------------------
	    |
		| The web-hook configuration automatically creates the necessary routes to
	    | route all the mandrill web hooks and attach a listener to the web hook
		|
	    */
		'web_hooks' => array(
			/*
		    |--------------------------------------------------------------------------
		    | Web Hook Configuration Enabled
		    |--------------------------------------------------------------------------
		    |
			| Indicates whether to enable or disable the configuration of web hooks
			|
		    */
			'enabled' => false,
			/*
		    |--------------------------------------------------------------------------
		    | Web Hook Configuration Enabled
		    |--------------------------------------------------------------------------
		    |
			| An array of route configurations that you wish to define for various
			| event types of mandrill. Refer to mandrill for various event types at
			| http://help.mandrill.com/entries/21738186-Introduction-to-Web-hooks
			|
		    */
			'routes'  => array(
				array(
					/*
				    |--------------------------------------------------------------------------
				    | Web Hook Configuration Enabled
				    |--------------------------------------------------------------------------
				    |
					| The route URL of the web-hook. On the example below it is configured as
					| /mandrill/send, the route will be configured to
					| http://base_url/mandrill/send
					|
				    */
					'route_url'   => '/mandrill/send',
					/*
				    |--------------------------------------------------------------------------
				    | Web Hook Event Types
				    |--------------------------------------------------------------------------
				    |
					| An array object that contains the list of events that have been configured
					| for this web hook. You would have done this when setting up the web hook on
					| the Mandrill Control Panel. The different event types are listed on
					| http://help.mandrill.com/entries/21738186-Introduction-to-Webhooks.
					| This configuration will only be used if verify_hook is set to true
					|
				    */
					'event_types' => array('send','hard_bounce'),
					/*
					|--------------------------------------------------------------------------
				    | Web Hook API Key
				    |--------------------------------------------------------------------------
				    |
					| A key that is automatically generated when a webhook is created.
					| This can be found on the Webhook Control panel of mandrill.
					| Every Webhook has a different key generated. Again, this configuration
					| will only be used if verify_hook is set to true
					|
					 */
					'webhook_key' => 'API_WEBHOOK_KEY',
					/*
					|--------------------------------------------------------------------------
				    | Web Hook Listeners
				    |--------------------------------------------------------------------------
				    |
					| The listener is used to configure a hook on the application to listen to
					| when the webhook is called. There are 2 listeners that you can configure.
					| Event, Queue. The type takes the type of listener that you want to configure
					| it to [event, queue]. The name takes the name of the listener that should
					| be called. A look at the Laravel docs on how to setup an Event Listener
					| or Queue will help understand.
					|
					 */
					'listener'    => array(
						'type' => 'event',
						'name' => ''
					),
					/*
					|--------------------------------------------------------------------------
				    | Mandrill Web Hook Verification
				    |--------------------------------------------------------------------------
				    |
					| It takes a boolean value and notifies the route to verify the web hook call.
					| There are 2 verfications that are done here
					| a. Mandrill sends an encrypted signature based on the data and the key
					|    of the webhook that can be used to verify if the web hook call is actually
					|    coming from Mandrill.
					| b. It checks if the event type matches the web_hook call.
					| Setting the configuration to true will automatically start validating the
					| web hook calls if the calls are from Mandrill or not.
					| No additional coding required
					|
					 */
					'verify_hook' => false
				)
			)
		)
	),
	'postmark' => array(
		'apikey' => 'POSTMARK_API_TEST'
	)
);