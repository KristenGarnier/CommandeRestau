<?php

namespace Restau\Controller;

use Restau\Entity\Like;
use Restau\Entity\Restaurant;
use Silex\Application;

class RestaurantController
{

    public function index(Application $app)
    {
        /*$restaurant = new Restaurant();
        $restaurant->setNom('Mr Greaser');
        $restaurant->setAdresse('4 rue de la place');
        $restaurant->setCp(43000);
        $restaurant->setVille('Le Puy en Velay');
        $restaurant->setFermeture('21:00');
        $restaurant->setOuverture('11:00');

        $app['repository.restaurant']->save($restaurant);*/

        $restaurants = $app['repository.restaurant']->findAll();

        return $app['twig']->render('restaurant/index.html.twig', array('restaurants' => $restaurants));
    }

    public function show(Application $app, $id){

        $restaurant = $app['repository.restaurant']->find($id);
        return $app['twig']->render('restaurant/show.html.twig', array('restaurant' => $restaurant, 'userLike' => $app['likechecker']->doUserLike($app['repository.user']->findByName($app['security.token_storage']->getToken()->getUser()->getUsername()), $restaurant)));

    }


    public function like(Application $app, $id){

        $restaurant = $app['repository.restaurant']->find($id);
        $user = $app['repository.user']->findByName($app['security.token_storage']->getToken()->getUser()->getUsername());
        try{
            $app['likechecker']->check($user, $restaurant);
        }catch (\Exception $e){
            $app['session']->getFlashBag()->add('error_like',$e->getMessage());
            return $app->redirect($app['url_generator']->generate('restaurant_show', array('id' => $id)));
        }

        $like = new Like();
        $like->setRestaurant($id);
        $like->setUser($user->getId());
        $app['repository.likes']->save($like);


        $likes = $app['repository.likes']->findByRestaurant($id);
        $restaurant->setLikes(count($likes));

        $app['repository.restaurant']->save($restaurant);
        return $app->redirect($app['url_generator']->generate('restaurant_show', array('id' => $id)));
    }

    public function dislike(){

    }

}