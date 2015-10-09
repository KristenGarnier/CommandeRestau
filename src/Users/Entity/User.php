<?php

namespace Utilisateurs\Entity;

class User
{
    private $id;
    private $username;
    private $password;
    private $roles;

    public function getId()     {
        return $this->id;
    }

    public function setId($id)     {
        $this->id = $id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPassword(){
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function setRoles($roles)
    {
        $this->roles = $roles;
    }
}