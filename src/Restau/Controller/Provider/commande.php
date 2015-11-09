<?php

namespace Restau\Controller\Provider;

use \Silex\Application;
use \Silex\ControllerProviderInterface;

class commande implements ControllerProviderInterface
{

    public function connect(Application $app){
        $commande = $app["controllers_factory"];

        $commande->get('/', "Restau\\Controller\\CommandeController::index")->bind("commande_index");

        return $commande;
    }

}