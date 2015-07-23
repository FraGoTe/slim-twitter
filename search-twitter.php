<?php

require_once 'vendor/autoload.php';

use Slim\Slim;
use ZendService\Twitter\Twitter;


$twitterAuth = array(
    'access_token' => array(
        'token'  => '22295195-qfcZMxj4yelq4Xfynm1ZtwXM22Gwh0h3h2mh3FOBx',
        'secret' => 'rDDk2ziCdIobHfeIRfLxH7OOzjzDQeA2XB353MGprApKG',
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

$app = new Slim();
$twitter = new Twitter($twitterAuth);

$app->map('/', function () use ($app, $twitter) {
    $twitterConfig = array(
        'screen_name' => 'FraGoTe',
        'include_rts' => 'false',
        'count' => 10,
    );
    
    if (empty($_REQUEST['search'])) {
        $twitterData = $twitter->statuses->userTimeline($twitterConfig);
        $tweets = $twitterData->toValue();
    } else {
        $twitterData = $twitter->searchTweets($_REQUEST['search'], $twitterConfig);
        if (!empty($twitterData)) {
            $twitterData = $twitterData->toValue();
            $tweets = $twitterData->statuses;
        }
    }
    
    echo json_encode($tweets);
})->via('GET', 'POST');

$app->run();