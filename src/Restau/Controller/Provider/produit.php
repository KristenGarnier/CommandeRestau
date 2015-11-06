<?php

namespace Restau\Controller\Provider;

use \Silex\Application;
use \Silex\ControllerProviderInterface;

class produit implements ControllerProviderInterface
{

    public function connect(Application $app){
        $produit = $app["controllers_factory"];

        $produit->get('/', "Restau\\Controller\\ProduitController::index")->bind("produit_index");

        $produit->get('/create', "Restau\\Controller\\ProduitController::create")->bind("produit_create");
        $produit->post('/create', "Restau\\Controller\\ProduitController::create")->bind("produit_create_post");

        $produit->get('/update/{id}', "Restau\\Controller\\ProduitController::update")->bind("produit_update");
        $produit->post('/update/{id}', "Restau\\Controller\\ProduitController::update")->bind("produit_update_post");

        return $produit;
    }

}