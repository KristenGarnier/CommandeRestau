<?php

namespace Utilisateurs\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Utilisateurs\Entity\User;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class UserController
{

    public function register(Application $app){
        return $app['twig']->render('create.html.twig', array('error'=> ''));
    }

    public function store(Application $app, Request $request){
        $username = $request->request->get('username');
        $password = $request->request->get('password');

        $user = new User();
        $user->setUsername($username);
        $user->setPassword($password);
        $user->setRoles('ROLE_USER');

        try {
            $app['repository.user']->save($user);

        } catch(\Exception $e){
            return $app['twig']->render('create.html.twig', array('error' => 'Le nom d\'utilisateur est déjà pris.'));
        }


        $app['session']->getFlashBag()->add('success_register','Veuillez maintenant vous connecter ' . $user->getUsername() );

        return $app->redirect($app["url_generator"]->generate("start"));
    }

    public function destroy(Application $app){

        $user = $app['repository.user']->findByName($app['security.token_storage']->getToken()->getUser());

        $app['repository.user']->delete($user);

        return new RedirectResponse('/');
    }

    public function update(Request $request, Application $app){
        $user = $app['repository.user']->findByName($app['security.token_storage']->getToken()->getUser());

        if ($request->getMethod() == 'POST'){
            $newUsername = $request->request->get('username');
            $newPassword = $request->request->get('password');
            $newPasswordEncoded = $app['security.encoder.digest']->encodePassword($newPassword, '');

            if($newPasswordEncoded != $user->getPassword() && $newPassword != null && $newPassword != ''){
                $user->setPassword($newPassword);
            }
            if($newUsername != $user->getUsername()){
                $user->setUsername($newUsername);
            }

            $app['repository.user']->save($user);

            return $app->redirect($app["url_generator"]->generate("start"));
        }

        return $app['twig']->render('register.html.twig', array(
            'user' => $user,
        ));

    }

}