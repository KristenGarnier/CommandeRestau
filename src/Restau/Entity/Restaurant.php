<?php

namespace Restau\Entity;

class Restaurant
{

    private $id;
    private $nom;
    private $adresse;
    private $cp;
    private $ville;
    private $ouverture;
    private $fermeture;
    private $likes;

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

    public function getAdresse()
    {
        return $this->nom;
    }

    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    public function getCp()
    {
        return $this->cp;
    }

    public function setCp($cp)
    {
        $this->cp = $cp;
    }

    public function getVille()
    {
        return $this->ville;
    }

    public function setVille($ville)
    {
        $this->ville = $ville;
    }

    public function getOuverture()
    {
        return $this->ouverture;
    }

    public function setOuverture($ouverture)
    {
        $this->ouverture = $ouverture;
    }

    public function getFermeture()
    {
        return $this->fermeture;
    }

    public function setFermeture($fermeture)
    {
        $this->fermeture = $fermeture;
    }

    public function getLikes()
    {
        return $this->likes;
    }

    public function setLikes($like)
    {
        $this->likes = $like;
    }
}