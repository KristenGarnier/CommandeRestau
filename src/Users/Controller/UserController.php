<?php

namespace Utilisateurs\Controller;

use Silex\Application;

class UserController
{

    public function register(Application $app){
        return $app['twig']->render('register.html.twig', array(
            'name' => 'utilisateur',
        ));
    }

    public function store(){

    }

}