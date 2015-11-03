<?php

namespace Restau\Controller\Provider;

use \Silex\Application;
use \Silex\ControllerProviderInterface;

class restaurant implements ControllerProviderInterface
{

    public function connect(Application $app){
        $restau = $app["controllers_factory"];

        $restau->get('/', "Restau\\Controller\\RestaurantController::index")->bind("restaurant_index");
        $restau->get('/{id}', "Restau\\Controller\\RestaurantController::show")
            ->bind("restaurant_show")
            ->assert('id', '\d+');
        $restau->get('/like/{id}', "Restau\\Controller\\RestaurantController::like")
            ->bind("restaurant_like")
            ->assert('id', '\d+');
        $restau->get('/dislike/{id}', "Restau\\Controller\\RestaurantController::dislike")
            ->bind("restaurant_dislike")
            ->assert('id', '\d+');
        $restau->get('/create', "Restau\\Controller\\RestaurantController::create")
            ->bind("restaurant_create");
        $restau->post('/create', "Restau\\Controller\\RestaurantController::create")
            ->bind("restaurant_create_form");
        $restau->get('/update/{id}', "Restau\\Controller\\RestaurantController::update")
            ->bind("restaurant_update")
            ->assert('id', '\d+');
        $restau->post('/update/{id}', "Restau\\Controller\\RestaurantController::update")
            ->bind("restaurant_update_form")
            ->assert('id', '\d+');
        $restau->get('/delete/{id}', "Restau\\Controller\\RestaurantController::delete")
            ->bind("restaurant_delete")
            ->assert('id', '\d+');

        return $restau;
    }

}