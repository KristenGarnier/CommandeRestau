<?php

namespace Restau\Entity;

class Menu
{

    private $id;
    private $nom;
    private $prix;
    private $restaurant_id;
    private $produit_id;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getRestaurant()
    {
        return $this->restaurant_id;
    }

    public function setRestaurant($restaurant)
    {
        $this->restaurant_id = $restaurant;
    }

    public function getProduit()
    {
        return $this->produit_id;
    }

    public function setProduit($produit)
    {
        $this->produit_id = $produit;
    }

    public function getBoisson()
    {
        return $this->boisson;
    }

    public function setBoisson($boisson)
    {
        $this->boisson = $boisson;
    }

    public function getDessert()
    {
        return $this->dessert;
    }

    public function setDessert($dessert)
    {
        $this->dessert = $dessert;
    }

    public function getPrix()
    {
        return $this->prix;
    }

    public function setPrix($prix)
    {
        $this->prix = $prix;
    }
}