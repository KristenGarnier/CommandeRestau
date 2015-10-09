<?php

namespace Utilisateurs\Controller\Provider;

use \Silex\Application;
use \Silex\ControllerProviderInterface;


class Utilisateur implements ControllerProviderInterface
{

    public function connect(Application $app){
        $user = $app["controllers_factory"];

        $user->get('/', "Utilisateurs\\Controller\\UserController::register");
        $user->post('/', "Utilisateurs\\Controller\\UserController::store");

        return $user;
    }

}