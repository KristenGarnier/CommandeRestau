<?php

namespace Restau\Controller;

use Restau\Entity\Commande;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class CommandeController
{

    public function index(Application $app)
    {
        return $app['twig']->render('commande/index.html.twig');
    }

    public function store(Request $request, Application $app){
        $commande = json_decode($request->getContent());

        return $app->json($app['security.token_storage']->getToken()->getUser());
    }

    public function getRestaurants(Application $app){
        return $app->json($app['repository.restaurant']->findAllArray());
    }

    public function getDesserts(Application $app, $id){
        return $app->json($app['repository.produits']->findByTypeRestaurantArray('dessert',$id));
    }

    public function getMenus(Application $app, $id){
        return $app->json($app['repository.produits']->findByTypeRestaurantArray('primary',$id));
    }

    public function getBoissons(Application $app, $id){
        return $app->json($app['repository.produits']->findByTypeRestaurantArray('boisson',$id));
    }

    public function getAll(Application $app, $id){
        return $app->json($app['repository.produits']->findAllRestaurantArray($id));
    }

}