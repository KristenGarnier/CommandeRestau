<?php

namespace Restau\Controller\Provider;

use \Silex\Application;
use \Silex\ControllerProviderInterface;

class menu implements ControllerProviderInterface
{

    public function connect(Application $app){
        $menu = $app["controllers_factory"];

        $menu->get('/', "Restau\\Controller\\MenuController::index")->bind("menu_index");

        $menu->get('/create', "Restau\\Controller\\MenuController::create")->bind("menu_create");
        $menu->post('/create', "Restau\\Controller\\MenuController::create")->bind("menu_create_post");

        $menu->get('/update/{id}', "Restau\\Controller\\MenuController::update")
            ->bind("menu_update")
            ->assert('id', '\d+');
        $menu->post('/update/{id}', "Restau\\Controller\\MenuController::update")
            ->bind("menu_update_post")
            ->assert('id', '\d+');

        $menu->get('/delete/{id}', "Restau\\Controller\\MenuController::delete")
            ->bind("menu_delete")
            ->assert('id', '\d+');

        return $menu;
    }

}