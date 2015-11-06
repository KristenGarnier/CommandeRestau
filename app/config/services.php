<?php

use Symfony\Component\Yaml\Parser;
use Restau\Services\ConfigService;
use Utilisateurs\Repository\UserRepository;
use Restau\Repository\RestaurantRepository;
use Restau\Repository\LikeRepository;
use Restau\Services\LikeChecker;
use Restau\Repository\ProduitRepository;
use Restau\Services\Uploadhandeler;
use Restau\Repository\MenuRepository;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../../ressources/views',
));

$app->register(new Silex\Provider\SessionServiceProvider());

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\RememberMeServiceProvider());

$app['repository.user'] = $app->share(function ($app) {
    return new UserRepository($app['db'], $app['security.encoder.digest']);
});

$app['repository.restaurant'] = $app->share(function ($app) {
    return new RestaurantRepository($app['db']);
});

$app['repository.likes'] = $app->share(function ($app) {
    return new LikeRepository($app['db']);
});

$app['repository.produits'] = $app->share(function ($app) {
    return new ProduitRepository($app['db']);
});

$app['repository.menus'] = $app->share(function ($app) {
    return new MenuRepository($app['db']);
});

$app['yaml'] = $app->share(function(){
    return new Parser();
});

$app['config'] = $app->share(function($app) {
    return new ConfigService($app['yaml']);
});

$app['likechecker'] = $app->share(function($app){
    return new LikeChecker($app);
});

$app['uploadhandeler'] = $app->share(function($app){
    return new Uploadhandeler($app);
});