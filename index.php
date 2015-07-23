<?php

require_once 'vendor/autoload.php';

use Slim\Slim;

$slimConfig = array(
    'templates.path' => 'view'
);

$app = new Slim($slimConfig);

$app->map('/', function () use ($app) {
    
     $app->render('index.twig');
     
})->via('GET', 'POST');

$app->run();