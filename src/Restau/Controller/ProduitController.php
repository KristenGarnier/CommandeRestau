<?php

namespace Restau\Controller;

use Restau\Entity\Like;
use Restau\Entity\Produit;
use Restau\Entity\Restaurant;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class ProduitController
{

    public function index(Application $app)
    {

        $produits = $app['repository.produits']->findAll();

        return $app['twig']->render('produit/index.html.twig', array('produits' => $produits));

        /* $files = $request->files->get($form->getName());
            /* Make sure that Upload Directory is properly configured and writable
        $path = __DIR__.'/../web/upload/';
        $filename = $files['FileUpload']->getClientOriginalName();
        $files['FileUpload']->move($path,$filename);*/
    }

    public function create(Application $app, Request $request){

        if($request->getMethod() == 'POST'){
            $produit = new Produit();

            $produit->setNom($request->get('nom'));
            $produit->setPrix($request->get('prix'));
            $produit->setType($request->get('type'));

            $file = $request->files->get('imageproduit');

            $produit->setImage($app['uploadhandeler']->uploadFile($file));

            $app['repository.produits']->save($produit);

            return $app->redirect($app['url_generator']->generate('produit_index'));
        }
        return $app['twig']->render('produit/create.html.twig');
    }

}