<?php

namespace Restau\Controller;

use Restau\Entity\Menu;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class MenuController
{

    public function index(Application $app)
    {

        $menus = $app['repository.menus']->findAll();
        return $app['twig']->render('menu/index.html.twig', array('menus' => $menus));
    }

    public function create(Application $app, Request $request){

        if ($request->getMethod() == 'POST') {
            $menu = new Menu();
            $menu->setNom($request->get('nom'));
            $menu->setPrix($request->get('prix'));
            $menu->setRestaurant($request->get('restau'));
            $menu->setProduit($request->get('primary'));
            $menu->setBoisson($request->get('boisson'));
            $menu->setDessert($request->get('dessert'));

            $app['repository.menus']->save($menu);

            return $app->redirect($app['url_generator']->generate('menu_index'));
        }

        $restaurants = $app['repository.restaurant']->findAll();
        $produits = $app['repository.produits']->findByType('primary');
        $boissons = $app['repository.produits']->findByType('boisson');
        $desserts = $app['repository.produits']->findByType('dessert');

        return $app['twig']->render('menu/create.html.twig', array('restaurants' => $restaurants, 'primarys' => $produits, 'boissons' => $boissons, 'desserts' => $desserts));
    }

}