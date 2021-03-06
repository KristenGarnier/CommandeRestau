<?php

use Symfony\Component\HttpFoundation\Request;

$app->get('/', function(Request $request) use ($app) {

    if ($app['security.authorization_checker']->isGranted('ROLE_USER')) {
        return $app['twig']->render('test.html.twig');
    }

    return $app['twig']->render('index.html.twig', array(
        'error' => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
})->bind('start');

$app->mount('/restaurants', new Restau\Controller\Provider\restaurant());
$app->mount('/commandes', new Restau\Controller\Provider\commande());
$app->mount('/produits', new Restau\Controller\Provider\produit());
$app->mount('/menus', new Restau\Controller\Provider\menu());
$app->mount('/users', new Utilisateurs\Controller\Provider\Utilisateur());