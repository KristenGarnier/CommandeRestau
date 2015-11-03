<?php

namespace Restau\Repository;

use Doctrine\DBAL\Connection;
use Restau\Entity\Restaurant;
use Utilisateurs\Entity\User;
use Utilisateurs\Repository\RepositoryInterface;

class RestaurantRepository implements RepositoryInterface
{

    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }
    
    /**
     * Saves the restaurant to the database.
     *
     * @param Restaurant $restaurant
     *
     * @return Restaurant $restaurant
     */
    public function save($restaurant)
    {
        $restaurantData = array(
            'nom' => $restaurant->getNom(),
            'adresse' => $restaurant->getAdresse(),
            'cp' => $restaurant->getCp(),
            'ville' => $restaurant->getVille(),
            'ouverture' => $restaurant->getOuverture(),
            'fermeture' => $restaurant->getFermeture(),
            'likes' => $restaurant->getLikes()
        );
        if ($restaurant->getId()) {
            $this->db->update('restaurants', $restaurantData, array('id' => $restaurant->getId()));
        }
        else {

            $this->db->insert('restaurants', $restaurantData);
            $last = $this->db->lastInsertId();
            return $this->find($last);
        }
    }


    /**
     * Deletes the restaurant.
     *
     * @param Restaurant $restaurant
     *
     * @return boolean
     */
    public function delete($restaurant)
    {
        return $this->db->delete('restaurants', array('id' => $restaurant->getId()));
    }
    /**
     * Returns the total number of restaurants.
     *
     * @return integer The total number of restaurants.
     */
    public function getCount() {
        return $this->db->fetchColumn('SELECT COUNT(id) FROM restaurants');
    }
    /**
     * Returns an restaurant matching the supplied id.
     *
     * @param integer $id
     *
     * @return User|false An entity object if found, false otherwise.
     */
    public function find($id)
    {
        $restaurantData = $this->db->fetchAssoc('SELECT * FROM restaurants WHERE id = ?', array($id));
        return $restaurantData ? $this->buildRestaurant($restaurantData) : FALSE;
    }

    /**
     * Returns an restaurant matching the supplied restaurant name.
     *
     * @param string $nom
     *
     * @return Restaurant|false An entity object if found, false otherwise.
     */
    public function findByName($nom)
    {
        $restaurantData = $this->db->fetchAssoc('SELECT * FROM restaurants WHERE nom = ?', array($nom));
        return $restaurantData ? $this->buildrestaurant($restaurantData) : FALSE;
    }

    /**
     * Returns a collection of restaurants, sorted by name.
     *
     * @param integer $limit
     *   The number of restaurants to return.
     * @param integer $offset
     *   The number of restaurants to skip.
     * @param array $orderBy
     *   Optionally, the order by info, in the $column => $direction format.
     *
     * @return array A collection of restaurants, keyed by restaurant id.
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
                ->from('restaurants', 'r')
                ->setMaxResults($limit)
                ->setFirstResult($offset)
                ->orderBy('r.' . key($orderBy), current($orderBy));
        }else {
            $queryBuilder
                ->select('r.*')
                ->from('restaurants', 'r')
                ->setFirstResult($offset)
                ->orderBy('r.' . key($orderBy), current($orderBy));
        }
        $statement = $queryBuilder->execute();
        $restaurantsData = $statement->fetchAll();
        $restaurants = array();
        foreach ($restaurantsData as $restaurantData) {
            $restaurantId = $restaurantData['id'];
            $restaurants[$restaurantId] = $this->buildRestaurant($restaurantData);
        }
        return $restaurants;
    }
    /**
     * Instantiates an user entity and sets its properties using db data.
     *
     * @param array restaurantData
     *   The array of db data.
     *
     * @return Restaurant
     */
    protected function buildRestaurant($restaurantData)
    {
        $restaurant = new Restaurant();
        $restaurant->setId($restaurantData['id']);
        $restaurant->setNom($restaurantData['nom']);
        $restaurant->setAdresse($restaurantData['adresse']);
        $restaurant->setCp($restaurantData['cp']);
        $restaurant->setVille($restaurantData['ville']);
        $restaurant->setOuverture($restaurantData['ouverture']);
        $restaurant->setFermeture($restaurantData['fermeture']);
        $restaurant->setLikes($restaurantData['likes']);

        return $restaurant;
    }

}