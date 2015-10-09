<?php

use Symfony\Component\Yaml\Parser;
use Restau\Services\ConfigService;
use Utilisateurs\Repository\UserRepository;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../../ressources/views',
));

$app->register(new Silex\Provider\SessionServiceProvider());

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\RememberMeServiceProvider());

$app['repository.user'] = $app->share(function ($app) {
    return new UserRepository($app['db'], $app['security.encoder.digest']);
});

$app['yaml'] = $app->share(function(){
    return new Parser();
});

$app['config'] = $app->share(function($app) {
    return new ConfigService($app['yaml']);
});