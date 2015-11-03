<?php

namespace Restau\Controller;

use Restau\Entity\Like;
use Restau\Entity\Restaurant;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class RestaurantController
{

    public function index(Application $app)
    {
        /**/

        $restaurants = $app['repository.restaurant']->findAll(false, 0, array('likes' => 'DESC'));

        return $app['twig']->render('restaurant/index.html.twig', array('restaurants' => $restaurants));
    }

    public function show(Application $app, $id)
    {

        $restaurant = $app['repository.restaurant']->find($id);
        return $app['twig']->render('restaurant/show.html.twig', array('restaurant' => $restaurant, 'userLike' => $app['likechecker']->doUserLike($app['repository.user']->findByName($app['security.token_storage']->getToken()->getUser()->getUsername()), $restaurant)));

    }


    public function like(Application $app, $id)
    {

        $restaurant = $app['repository.restaurant']->find($id);
        $user = $app['repository.user']->findByName($app['security.token_storage']->getToken()->getUser()->getUsername());
        try {
            $app['likechecker']->check($user, $restaurant);
        } catch (\Exception $e) {
            $app['session']->getFlashBag()->add('error_like', $e->getMessage());
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

    public function dislike(Application $app, $id)
    {
        $restaurant = $app['repository.restaurant']->find($id);
        $user = $app['repository.user']->findByName($app['security.token_storage']->getToken()->getUser()->getUsername());

        $likes = $app['repository.likes']->findByUser($user->getId());

        $like = array_map(function ($like) use ($restaurant) {
            if ($restaurant->getId() == $like->getRestaurant()) {
                return $like;
            }
        }, $likes);

        $app['repository.likes']->delete(array_values($like)[0]);

        $likes = $app['repository.likes']->findByRestaurant($id);
        $restaurant->setLikes(count($likes) - 1);

        return $app->redirect($app['url_generator']->generate('restaurant_show', array('id' => $id)));
    }

    public function create(Application $app, Request $request)
    {

        if ($request->getMethod() == 'POST') {

            $restaurant = new Restaurant();
            $restaurant->setNom($request->get('nom'));
            $restaurant->setAdresse($request->get('adresse'));
            $restaurant->setCp($request->get('cp'));
            $restaurant->setVille($request->get('ville'));
            $restaurant->setFermeture($request->get('fermeture'));
            $restaurant->setOuverture($request->get('ouverture'));
            $restaurant->setLikes(0);

            $app['repository.restaurant']->save($restaurant);

            return $app->redirect($app['url_generator']->generate('restaurant_index'));
        }

        return $app['twig']->render('restaurant/create.html.twig');

    }

    public function update(Application $app, Request $request, $id){

        $restaurant = $app['repository.restaurant']->find($id);

        if ($request->getMethod() == 'POST') {
            $restaurant->setNom($request->get('nom'));
            $restaurant->setAdresse($request->get('adresse'));
            $restaurant->setCp($request->get('cp'));
            $restaurant->setVille($request->get('ville'));
            $restaurant->setFermeture($request->get('fermeture'));
            $restaurant->setOuverture($request->get('ouverture'));

            $app['repository.restaurant']->save($restaurant);

            return $app->redirect($app['url_generator']->generate('restaurant_show', array('id' => $id)));
        }
        return $app['twig']->render('restaurant/create.html.twig', array('restaurant' => $restaurant));
    }

}