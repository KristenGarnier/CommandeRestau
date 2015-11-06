<?php

namespace Restau\Repository;

use Doctrine\DBAL\Connection;
use Restau\Entity\Menu;
use Silex\Application;
use Utilisateurs\Entity\User;
use Utilisateurs\Repository\RepositoryInterface;

class MenuRepository implements RepositoryInterface
{

    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $db;
    protected $app;

    public function __construct(Connection $db,Application $app)
    {
        $this->db = $db;
        $this->app = $app;
    }
    
    /**
     * Saves the menu to the database.
     *
     * @param Menu $menu
     *
     * @return Menu $menu
     */
    public function save($menu)
    {
        $menuData = array(
            'nom' => $menu->getNom(),
            'prix' => $menu->getPrix(),
            'restaurant_id' => $menu->getRestaurant(),
            'primary_id' => $menu->getProduit(),
            'boisson' => $menu->getBoisson(),
            'dessert' => $menu->getDessert()
        );
        if ($menu->getId()) {
            $this->db->update('menus', $menuData, array('id' => $menu->getId()));
        }
        else {

            $this->db->insert('menus', $menuData);
            $last = $this->db->lastInsertId();
            return $this->find($last);
        }
    }


    /**
     * Deletes the menu.
     *
     * @param Menu $menu
     *
     * @return boolean
     */
    public function delete($menu)
    {
        return $this->db->delete('menus', array('id' => $menu->getId()));
    }
    /**
     * Returns the total number of menus.
     *
     * @return integer The total number of menus.
     */
    public function getCount() {
        return $this->db->fetchColumn('SELECT COUNT(id) FROM menus');
    }
    /**
     * Returns an menu matching the supplied id.
     *
     * @param integer $id
     *
     * @return User|false An entity object if found, false otherwise.
     */
    public function find($id)
    {
        $menuData = $this->db->fetchAssoc('SELECT * FROM menus WHERE id = ?', array($id));
        return $menuData ? $this->buildMenu($menuData) : FALSE;
    }


    /**
     * Returns a collection of menus, sorted by name.
     *
     * @param integer $limit
     *   The number of menu to return.
     * @param integer $offset
     *   The number of menu to skip.
     * @param array $orderBy
     *   Optionally, the order by info, in the $column => $direction format.
     *
     * @return array A collection of menu, keyed by like id.
     */
    public function findAll($limit = false, $offset = 0, $orderBy = array())
    {
        // Provide a default orderBy.
        if (!$orderBy) {
            $orderBy = array('nom' => 'ASC');
        }
        $queryBuilder = $this->db->createQueryBuilder();

        if($limit) {
            $queryBuilder
                ->select('r.*')
                ->from('menus', 'r')
                ->setMaxResults($limit)
                ->setFirstResult($offset)
                ->orderBy('r.' . key($orderBy), current($orderBy));
        }else {
            $queryBuilder
                ->select('r.*')
                ->from('menus', 'r')
                ->setFirstResult($offset)
                ->orderBy('r.' . key($orderBy), current($orderBy));
        }
        $statement = $queryBuilder->execute();
        $menusData = $statement->fetchAll();
        $likes = array();
        foreach ($menusData as $menuData) {
            $likeId = $menuData['id'];
            $likes[$likeId] = $this->buildMenu($menuData);
        }
        return $likes;
    }
    /**
     * Instantiates an menu entity and sets its properties using db data.
     *
     * @param array $menuData
     *   The array of db data.
     *
     * @return Menu
     */
    protected function buildMenu($menuData)
    {
        $menu = new Menu();
        $menu->setId($menuData['id']);
        $menu->setNom($menuData['nom']);
        $menu->setPrix($menuData['prix']);
        $restau = $this->app['repository.restaurant']->find($menuData['restaurant_id']);
        $menu->setRestaurant( $restau);
        $primary = $this->app['repository.produits']->find($menuData['primary_id']);
        $menu->setProduit($primary);
        $menu->setBoisson($menuData['boisson']);
        $menu->setDessert($menuData['dessert']);

        return $menu;
    }

}