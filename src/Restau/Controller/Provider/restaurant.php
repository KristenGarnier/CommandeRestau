<?php

namespace Restau\Controller\Provider;

use \Silex\Application;
use \Silex\ControllerProviderInterface;

class restaurant implements ControllerProviderInterface
{

    public function connect(Application $app){
        $login = $app["controllers_factory"];

        $login->get('/', "Restau\\Controller\\RestaurantController::index")->bind("restaurant_index");
        $login->get('/{id}', "Restau\\Controller\\RestaurantController::show")
            ->bind("restaurant_show")
            ->assert('id', '\d+');
        $login->get('/like/{id}', "Restau\\Controller\\RestaurantController::like")
            ->bind("restaurant_like")
            ->assert('id', '\d+');
        $login->get('/dislike/{id}', "Restau\\Controller\\RestaurantController::dislike")
            ->bind("restaurant_dislike")
            ->assert('id', '\d+');
        return $login;
    }

}