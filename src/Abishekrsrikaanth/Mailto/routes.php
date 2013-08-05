<?php

$route_config_items = Config::get('mailto::providers.mandrill.routes');

if (count($route_config_items) > 0) {
	try {
		foreach ($route_config_items as $route_item) {
			if (count($route_item) == 5) {
				Route::get($route_item['route_url'], function () use ($route_item) {
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
	} catch (Exception $ex) {
		echo print_r($ex, true);
	}
}
//Route::get('/web-hooks/mandrill/send', function () {
//	$mandrill_input = Input::get('mandrill_events');
//	Event::fire('mandrill-send', array('data' => json_decode($mandrill_input, true)));
//
//});
//
//Route::post('/web-hooks/mandrill/hard_bounce', function () {
//
//});
//
//Route::post('/web-hooks/mandrill/soft_bounce', function () {
//
//});
//
//Route::post('/web-hooks/mandrill/open', function () {
//
//});
//
//Route::post('/web-hooks/mandrill/click', function () {
//
//});
//
//Route::post('/web-hooks/mandrill/spam', function () {
//
//});
//
//Route::post('/web-hooks/mandrill/unsub', function () {
//
//});
//
//Route::post('/web-hooks/mandrill/reject', function () {
//
//});