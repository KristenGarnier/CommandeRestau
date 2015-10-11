<?php

namespace Utilisateurs\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Utilisateurs\Entity\User;

class UserController
{

    public function register(Application $app){
        return $app['twig']->render('register.html.twig', array(
            'name' => 'utilisateur',
        ));
    }

    public function store(Application $app, Request $request){
        $username = $request->request->get('username');
        $password = $request->request->get('password');
        $user = new User();
        $user->setUsername($username);
        $user->setPassword($password);
        $user->setRoles('ROLE_USER');

        $userFinal = $app['repository.user']->save($user);

        return $app->json($userFinal);
    }

    public function destroy(Application $app){

        $user = $app['repository.user']->findByName($app['security.token_storage']->getToken()->getUser());

        $app['repository.user']->delete($user);

        return new RedirectResponse('/');
    }

}