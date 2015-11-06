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
            if($request->get('boisson') == 'on'){

                $menu->setBoisson(true);
            }else{
                $menu->setBoisson(false);
            }
            if($request->get('dessert') == 'on'){
                $menu->setDessert(true);
            }else {
                $menu->setDessert(false);
            }


            $app['repository.menus']->save($menu);

            return $app->redirect($app['url_generator']->generate('menu_index'));
        }

        $restaurants = $app['repository.restaurant']->findAll();
        $produits = $app['repository.produits']->findByType('primary');

        return $app['twig']->render('menu/create.html.twig', array('restaurants' => $restaurants, 'primarys' => $produits));
    }

    public function update(Application $app, Request $request, $id){

        $menu = $app['repository.menus']->find($id);

        if ($request->getMethod() == 'POST') {
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

        return $app['twig']->render('menu/create.html.twig', array('menu' => $menu, 'restaurants' => $restaurants, 'primarys' => $produits));
    }

    public function delete(Application $app, $id){
        if (!$app['security.authorization_checker']->isGranted('ROLE_ADMIN')) {
            return $app->redirect($app['url_generator']->generate('menu_index'));
        }

        $menu = $app['repository.menus']->find($id);

        $app['repository.menus']->delete($menu);

        return $app->redirect($app['url_generator']->generate('menu_index'));
    }

}