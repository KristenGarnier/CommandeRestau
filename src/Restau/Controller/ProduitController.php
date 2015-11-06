<?php

namespace Restau\Controller;

use Restau\Entity\Produit;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class ProduitController
{

    public function index(Application $app)
    {

        $produits = $app['repository.produits']->findAll();

        return $app['twig']->render('produit/index.html.twig', array('produits' => $produits));
    }

    public function create(Application $app, Request $request)
    {

        if ($request->getMethod() == 'POST') {
            $produit = new Produit();

            $produit->setNom($request->get('nom'));
            $produit->setPrix($request->get('prix'));
            $produit->setType($request->get('type'));
            $produit->setRestaurant($request->get('restaurant'));

            $file = $request->files->get('imageproduit');

            $produit->setImage($app['uploadhandeler']->uploadFile($file));

            $app['repository.produits']->save($produit);

            return $app->redirect($app['url_generator']->generate('produit_index'));
        }

        $restaurants = $app['repository.restaurant']->findAll();
        return $app['twig']->render('produit/create.html.twig',array('restaurants' => $restaurants));
    }

    public function update(Application $app, Request $request, $id)
    {
        $produit = $app['repository.produits']->find($id);
        $restaurants = $app['repository.restaurant']->findAll();

        if($request->getMethod() == 'POST'){
            $produit->setNom($request->get('nom'));
            $produit->setPrix($request->get('prix'));
            $produit->setType($request->get('type'));
            $produit->setRestaurant($request->get('restaurant'));

            if($request->files->get('imageproduit')){
                $file = $request->files->get('imageproduit');

                $produit->setImage($app['uploadhandeler']->uploadFile($file));
            }

            $app['repository.produits']->save($produit);
            return $app->redirect($app['url_generator']->generate('produit_index'));
        }

        return $app['twig']->render('produit/create.html.twig', array('produit' => $produit, 'restaurants' => $restaurants));
    }

    public function delete(Application $app, $id){
        if (!$app['security.authorization_checker']->isGranted('ROLE_ADMIN')) {
            return $app->redirect($app['url_generator']->generate('produit_index'));
        }

        $restaurant = $app['repository.produits']->find($id);

        $app['repository.produits']->delete($restaurant);

        return $app->redirect($app['url_generator']->generate('produit_index'));
    }

}