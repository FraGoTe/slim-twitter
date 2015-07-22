<?php

require_once 'vendor/autoload.php';

use Zend\Http\Request;
use Zend\Http\Client;
use Zend\Stdlib\Parameters;
use Slim\Slim;

$app = new Slim(
	array(
		'templates.path' => 'view'
	)
);

$app->map('/', function () use ($app) {
	$twitterUsername = 'FraGoTe';
	$timeLineUrl = 'https://api.twitter.com/1.1/statuses/user_timeline.json?user_id=' . $twitterUsername;

	$request = new Request();
	$request->getHeaders()->addHeaders(
		array(
	    	'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8',
	    	'Authorization' => ' Authorization: OAuth oauth_consumer_key="8Pqof9viqPpQNUX7868zeRmjA", oauth_nonce="7a3c32b7c1323c08be13bec2aadba3cf", oauth_signature="y7uQ2RjFKezy1VFQY5LU96KFnKY%3D", oauth_signature_method="HMAC-SHA1", oauth_timestamp="1437534655", oauth_token="22295195-HmsGlFHZAQDGTY7wDw5rCbwTRX5xpWXDoKLbKm035", oauth_version="1.0"'
		)
	);

	$request->setUri($timeLineUrl);
	$request->setMethod('GET');

	$client = new Client();
	$response = $client->dispatch($request);
	$twitterData = json_decode($response->getBody(), true);
    
    $app->render('index.twig', array(
        'twitterData' => $twitterData
    ));
})->via('GET', 'POST');

$app->run();