<?php

namespace Utilisateurs\Controller;

use Silex\Application;
use Utilisateurs\Entity\User;

class UserController
{

    public function register(Application $app){
        return $app['twig']->render('register.html.twig', array(
            'name' => 'utilisateur',
        ));
    }

    public function store(Application $app){
        $user = new User();
        $user->setUsername('mayaka');
        $user->setPassword('salade69');
        $user->setRoles('ROLE_USER');

        $app['repository.user']->save($user);

        return $app->json($user);
    }

}