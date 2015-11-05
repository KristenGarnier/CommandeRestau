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

        $restaurants = $app['repository.restaurant']->findAll(false, 0, array('likes' => 'DESC'));

        return $app['twig']->render('restaurant/index.html.twig', array('restaurants' => $restaurants));

        /* $files = $request->files->get($form->getName());
            /* Make sure that Upload Directory is properly configured and writable
        $path = __DIR__.'/../web/upload/';
        $filename = $files['FileUpload']->getClientOriginalName();
        $files['FileUpload']->move($path,$filename);*/
    }

}