<?php

namespace Restau\Controller;

use Silex\Application;

class RestaurantController
{

    public function index(Application $app)
    {
        return $app['twig']->render('test.html.twig', array(
            'name' => 'kristen',
        ));
    }

}