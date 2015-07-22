<?php

require_once 'vendor/autoload.php';

use Slim\Slim;
use ZendService\Twitter\Twitter;

$slimConfig = array(
    'templates.path' => 'view'
);

$twitterAuth = array(
    'access_token' => array(
        'token'  => '22295195-HmsGlFHZAQDGTY7wDw5rCbwTRX5xpWXDoKLbKm035',
        'secret' => '4cjWbLPEbhnWcEirkTJuYd1j9S2xum6Otysa71zKPoher',
    ),
    'oauth_options' => array(
        'consumerKey' => '8Pqof9viqPpQNUX7868zeRmjA',
        'consumerSecret' => '7jBPKJZ1PDPnNEYG2SxxOkGSH7GRWVaqkQrORtX7yFCL8eghcj',
    ),
    'http_client_options' => array(
        'adapter' => 'Zend\Http\Client\Adapter\Curl',
        'curloptions' => array(
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSLVERSION => 4
        ),
    ),
);

$app = new Slim($slimConfig);
$twitter = new Twitter($twitterAuth);

$app->map('/', function () use ($app, $twitter) {
    //$response = $twitter->account->verifyCredentials();
    $twitterData = $twitter->statuses->userTimeline(array('screen_name' => 'FraGoTe'));
    
    $app->render('index.twig', array(
        'twitterData' => $twitterData->toValue()
    ));
})->via('GET', 'POST');

$app->run();