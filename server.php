<?php

<<<CONFIG
packages:
    - "silex/silex: *"
php-options:
    - "-S"
    - "localhost:8000"
CONFIG;

$app = new Silex\Application();
$app->get('/hello/{name}', function ($name) use ($app) {
    return 'Hello '.$app->escape($name);
});
$app->run();