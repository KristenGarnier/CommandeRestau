<?php

$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'register' => array('pattern' => '^/users$'), // Exemple d'une url accessible en mode non connecté
        'default' => array(
            'pattern' => '^.*$',
            'anonymous' => true, // Indispensable car la zone de login se trouve dans la zone sécurisée (tout le front-office)
            'form' => array('login_path' => '/', 'check_path' => 'connexion'),
            'logout' => array('logout_path' => '/deconnexion'), // url à appeler pour se déconnecter
            'users' => $app->share(function() use ($app) {
                // La classe App\User\UserProvider est spécifique à notre application et est décrite plus bas
                return new Utilisateurs\Controller\Provider\UserProvider($app['db']);
            }),
        ),
    ),
    'security.access_rules' => array(
        // ROLE_USER est défini arbitrairement, vous pouvez le remplacer par le nom que vous voulez
        array('^/users', 'IS_AUTHENTICATED_ANONYMOUSLY'),
        array('^/commande', 'IS_AUTHENTICATED_ANONYMOUSLY'),
        array('^/users/delete', 'ROLE_USER'), // Cette url est accessible en mode non connecté
    ),
    'security.role_hierarchy' => array(
        'ROLE_ADMIN' => array('ROLE_USER', 'ROLE_ALLOWED_TO_SWITCH')
    )
));