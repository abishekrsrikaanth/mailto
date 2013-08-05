<?php

//Getting the Config Routes
$check_webhooks_enabled = Config::get('mailto::providers.mandril.webhooks.enabled');
if ($check_webhooks_enabled == true) {
	$route_config_items = Config::get('mailto::providers.mandrill.webhooks.routes');
	if (count($route_config_items) > 0) {
		foreach ($route_config_items as $route_item) {
			if (count($route_item) == 5) {
				Route::any($route_item['route_url'], function () use ($route_item) {
					$mandrill_input = Input::get('mandrill_events');
					if ($route_item['verify_hook'] == true) {
						$mandrill_signature = Request::header('X-Mandrill-Signature');
						$signed_url         = URL::to('/') . $route_item['route_url'];
						$webhook_key        = $route_item['webhook_key'];
						$params             = Input::get();
						ksort($params);
						foreach ($params as $key => $value) {
							$signed_url .= $key;
							$signed_url .= $value;
						}
						$signed_key = base64_encode(hash_hmac('sha1', $signed_url, $webhook_key, true));
						if ($mandrill_signature != $signed_key)
							return 'Invalid Signature';
						else {
							$mandrill_input_obj = json_decode($mandrill_input, true);
							$mandrill_event     = $mandrill_input_obj['event'];
							if (!(in_array($mandrill_event, $route_item['route_types'])))
								return 'Invalid Route Type';
						}
					}
					if (array_key_exists('listener', $route_item)) {
						$listener = $route_item['listener'];
						if ($listener['type'] == 'event') {
							Event::fire($listener['name'], array('data' => $mandrill_input));
						} else if ($listener['type'] == 'queue') {
							Queue::push($listener['name'], array('data' => $mandrill_input));
						}
					}
				});
			}
		}
	}
}