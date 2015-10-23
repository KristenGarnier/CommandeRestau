<?php

namespace Restau\Services;

use Restau\Entity\Restaurant;
use Silex\Application;
use Symfony\Component\Yaml\Parser;
use Utilisateurs\Entity\User;

/**
 * Class ConfigService
 *
 * Allow to retrieve params for configurations purpose
 *
 * @package Api\Services
 */
class LikeChecker
{

    private $app;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function check(User $user, Restaurant $restaurant){
        $likes = $this->app['repository.likes']->findByUser($user->getId());
        foreach($likes as $like){
            if($like->getRestaurant() == $restaurant->getId()){
                throw new \Exception('Vous avez déjà liké ce restaurant');
            }
        }
    }

    public function doUserLike(User $user, Restaurant $restaurant){
        $likes = $this->app['repository.likes']->findByUser($user->getId());
        foreach($likes as $like){
            if($like->getRestaurant() == $restaurant->getId()){
                return true;
            }
        }
        return false;
    }

}