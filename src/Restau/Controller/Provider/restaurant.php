<?php

namespace Restau\Controller\Provider;

use \Silex\Application;
use \Silex\ControllerProviderInterface;

class restaurant implements ControllerProviderInterface
{

    public function connect(Application $app){
        $login = $app["controllers_factory"];

        $login->get('/', "Restau\\Controller\\RestaurantController::index")->bind("restaurant_index");
        return $login;
    }

}