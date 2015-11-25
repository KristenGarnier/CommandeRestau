<?php

namespace Restau\Controller\Provider;

use \Silex\Application;
use \Silex\ControllerProviderInterface;

class commande implements ControllerProviderInterface
{

    public function connect(Application $app){
        $commande = $app["controllers_factory"];

        $commande->get('/', "Restau\\Controller\\CommandeController::index")->bind("commande_index");
        $commande->post('/', "Restau\\Controller\\CommandeController::store")->bind("commande_store");

        $commande->get('/desserts/{id}', "Restau\\Controller\\CommandeController::getDesserts")->bind("commande_Desserts");
        $commande->get('/boissons/{id}', "Restau\\Controller\\CommandeController::getBoissons")->bind("commande_Boissons");
        $commande->get('/menus/{id}', "Restau\\Controller\\CommandeController::getMenus")->bind("commande_menus");
        $commande->get('/restaurants', "Restau\\Controller\\CommandeController::getRestaurants")->bind("commande_restaurants");
        $commande->get('/all/{id}', "Restau\\Controller\\CommandeController::getAll")->bind("commande_all");

        return $commande;
    }

}