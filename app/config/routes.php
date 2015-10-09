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
});

$app->mount('/commandes', new Restau\Controller\Provider\Login());
$app->mount('/users', new Utilisateurs\Controller\Provider\Utilisateur());