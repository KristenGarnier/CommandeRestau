<?php

namespace Utilisateurs\Repository;

use Utilisateurs\Repository\RepositoryInterface;
use Doctrine\DBAL\Connection;
use Utilisateurs\Entity\User;

class UserRepository implements RepositoryInterface
{

    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $db;
    protected $encoder;

    public function __construct(Connection $db, $encoder)
    {
        $this->db = $db;
        $this->encoder = $encoder;
    }
    /**
     * Saves the user to the database.
     *
     * @param User $user
     *
     * @return User $user
     */
    public function save($user)
    {
        $userData = array(
            'username' => $user->getUsername(),
            'password' => $user->getPassword(),
            'roles' => $user->getRoles(),
        );
        if ($user->getId()) {
            // If a new image was uploaded, make sure the filename gets set.
            $this->db->update('users', $userData, array('id' => $user->getId()));
        }
        else {

            $userData['password'] = $this->encoder->encodePassword($userData['password'], '');

            $this->db->insert('users', $userData);
            $last = $this->db->lastInsertId();
            return $this->find($last);
        }
    }


    /**
     * Deletes the user.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function delete($user)
    {
        // If the user had an image, delete it.
        return $this->db->delete('users', array('id' => $user->getId()));
    }
    /**
     * Returns the total number of users.
     *
     * @return integer The total number of users.
     */
    public function getCount() {
        return $this->db->fetchColumn('SELECT COUNT(id) FROM users');
    }
    /**
     * Returns an user matching the supplied id.
     *
     * @param integer $id
     *
     * @return User|false An entity object if found, false otherwise.
     */
    public function find($id)
    {
        $userData = $this->db->fetchAssoc('SELECT * FROM user WHERE id = ?', array($id));
        return $userData ? $this->buildUser($userData) : FALSE;
    }
    /**
     * Returns a collection of users, sorted by name.
     *
     * @param integer $limit
     *   The number of users to return.
     * @param integer $offset
     *   The number of users to skip.
     * @param array $orderBy
     *   Optionally, the order by info, in the $column => $direction format.
     *
     * @return array A collection of users, keyed by user id.
     */
    public function findAll($limit, $offset = 0, $orderBy = array())
    {
        // Provide a default orderBy.
        if (!$orderBy) {
            $orderBy = array('username' => 'ASC');
        }
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->select('u.*')
            ->from('users', 'u')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->orderBy('u.' . key($orderBy), current($orderBy));
        $statement = $queryBuilder->execute();
        $usersData = $statement->fetchAll();
        $users = array();
        foreach ($usersData as $userData) {
            $userId = $userData['id'];
            $users[$userId] = $this->buildUser($userData);
        }
        return $users;
    }
    /**
     * Instantiates an user entity and sets its properties using db data.
     *
     * @param array $userData
     *   The array of db data.
     *
     * @return User
     */
    protected function buildUser($userData)
    {
        $user = new User();
        $user->setId($userData['id']);
        $user->setUsername($userData['username']);
        $user->setPassword($userData['password']);
        $user->setRoles($userData['roles']);
        return $user;
    }

}