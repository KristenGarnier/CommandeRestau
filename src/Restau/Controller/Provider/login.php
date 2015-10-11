<?php

namespace Restau\Controller\Provider;

use \Silex\Application;
use \Silex\ControllerProviderInterface;

class login implements ControllerProviderInterface
{

    public function connect(Application $app){
        $login = $app["controllers_factory"];

        $login->get('/', "Restau\\Controller\\LoginController::index")->bind("commande");

        return $login;
    }

}