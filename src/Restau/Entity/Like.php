<?php

namespace Restau\Entity;

class Like
{

    private $id;
    private $restaurant_id;
    private $user_id;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getRestaurant()
    {
        return $this->restaurant_id;
    }

    public function setRestaurant($id)
    {
        $this->restaurant_id = $id;
    }

    public function getUser()
    {
        return $this->user_id;
    }

    public function setUser($id)
    {
        $this->user_id = $id;
    }
}