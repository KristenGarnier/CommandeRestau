<?php

namespace Restau\Controller;

use Restau\Entity\Commande;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class CommandeController
{

    public function index(Application $app)
    {
        return $app->json('hzidauh');
    }

}