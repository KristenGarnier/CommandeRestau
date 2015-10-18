<?php

namespace Utilisateurs\Controller\Provider;

use \Silex\Application;
use \Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;


class Utilisateur implements ControllerProviderInterface
{

    public function connect(Application $app){
        $user = $app["controllers_factory"];

        $user->get('/delete', "Utilisateurs\\Controller\\UserController::destroy");
        $user->get('/update', "Utilisateurs\\Controller\\UserController::update");
        $user->post('/update', "Utilisateurs\\Controller\\UserController::update");
        $user->get('/', "Utilisateurs\\Controller\\UserController::register")
        ->before(function(Request $request, Application $app){
            if( $app['security.token_storage']->getToken()->getUser() != 'anon.'){
                return $app->redirect($app["url_generator"]->generate("start"));
            }
        })->bind('inscription');
        $user->post('/', "Utilisateurs\\Controller\\UserController::store");

        return $user;
    }

}