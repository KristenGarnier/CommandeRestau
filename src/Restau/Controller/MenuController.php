<?php

namespace Restau\Controller;

use Restau\Entity\Like;
use Restau\Entity\Restaurant;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class MenuController
{

    public function index(Application $app)
    {

        $menus = $app['repository.menus']->findAll();
        return $app['twig']->render('menu/index.html.twig', array('menus' => $menus));
    }

}