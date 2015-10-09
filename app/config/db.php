<?php

$database = $app['config']->getDatabaseConfig();

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver' => $database['driver'],
        'host' => $database['host'],
        'dbname' => $database['dbname'],
        'user' => $database['user'],
        'password' => $database['password'],
        'charset' => 'utf8',
    ),
));