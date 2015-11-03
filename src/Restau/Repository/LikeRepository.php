<?php

namespace Restau\Repository;

use Doctrine\DBAL\Connection;
use Restau\Entity\Like;
use Utilisateurs\Entity\User;
use Utilisateurs\Repository\RepositoryInterface;

class LikeRepository implements RepositoryInterface
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
     * Saves the like to the database.
     *
     * @param Like $like
     *
     * @return Like $like
     */
    public function save($like)
    {
        $likeData = array(
            'restaurant_id' => $like->getRestaurant(),
            'user_id' => $like->getUser()
        );
        if ($like->getId()) {
            $this->db->update('likes', $likeData, array('id' => $like->getId()));
        }
        else {

            $this->db->insert('likes', $likeData);
            $last = $this->db->lastInsertId();
            return $this->find($last);
        }
    }


    /**
     * Deletes the like.
     *
     * @param Like $like
     *
     * @return boolean
     */
    public function delete($like)
    {
        return $this->db->delete('likes', array('id' => $like->getId()));
    }
    /**
     * Returns the total number of likes.
     *
     * @return integer The total number of likes.
     */
    public function getCount() {
        return $this->db->fetchColumn('SELECT COUNT(id) FROM likes');
    }
    /**
     * Returns an like matching the supplied id.
     *
     * @param integer $id
     *
     * @return User|false An entity object if found, false otherwise.
     */
    public function find($id)
    {
        $likeData = $this->db->fetchAssoc('SELECT * FROM likes WHERE id = ?', array($id));
        return $likeData ? $this->buildLike($likeData) : FALSE;
    }

    /**
     * Returns an like matching the supplied restaurant id.
     *
     * @param int $id
     *
     * @return Like|false An entity object if found, false otherwise.
     */
    public function findByRestaurant($id)
    {
        $likesData = $this->db->fetchAll('SELECT * FROM likes WHERE restaurant_id = ?', array($id));
        $likes = array();
        foreach ($likesData as $likeData) {
            $likeId = $likeData['id'];
            $likes[$likeId] = $this->buildLike($likeData);
        }
        return $likes;
    }

    /**
     * Returns an like matching the supplied user id.
     *
     * @param int $id
     *
     * @return Like|false An entity object if found, false otherwise.
     */
    public function findByUser($id)
    {
        $likesData = $this->db->fetchAll('SELECT * FROM likes WHERE user_id = ?', array($id));
        $likes = array();
        foreach ($likesData as $likeData) {
            $likeId = $likeData['id'];
            $likes[$likeId] = $this->buildLike($likeData);
        }
        return $likes;
    }

    /**
     * Returns a collection of likes, sorted by name.
     *
     * @param integer $limit
     *   The number of likes to return.
     * @param integer $offset
     *   The number of likes to skip.
     * @param array $orderBy
     *   Optionally, the order by info, in the $column => $direction format.
     *
     * @return array A collection of likes, keyed by like id.
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
                ->from('likes', 'r')
                ->setMaxResults($limit)
                ->setFirstResult($offset)
                ->orderBy('r.' . key($orderBy), current($orderBy));
        }else {
            $queryBuilder
                ->select('r.*')
                ->from('likes', 'r')
                ->setFirstResult($offset)
                ->orderBy('r.' . key($orderBy), current($orderBy));
        }
        $statement = $queryBuilder->execute();
        $likesData = $statement->fetchAll();
        $likes = array();
        foreach ($likesData as $likeData) {
            $likeId = $likeData['id'];
            $likes[$likeId] = $this->buildLike($likeData);
        }
        return $likes;
    }
    /**
     * Instantiates an user entity and sets its properties using db data.
     *
     * @param array likeData
     *   The array of db data.
     *
     * @return Like
     */
    protected function buildLike($likeData)
    {
        $like = new Like();
        $like->setId($likeData['id']);
        $like->setUser($likeData['user_id']);
        $like->setRestaurant($likeData['restaurant_id']);

        return $like;
    }

}