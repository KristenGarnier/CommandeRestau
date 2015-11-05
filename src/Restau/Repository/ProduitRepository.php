<?php

namespace Restau\Repository;

use Doctrine\DBAL\Connection;
use Restau\Entity\Produit;
use Utilisateurs\Entity\User;
use Utilisateurs\Repository\RepositoryInterface;

class ProduitRepository implements RepositoryInterface
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
     * Saves the produit to the database.
     *
     * @param Produit $produit
     *
     * @return Produit $produit
     */
    public function save($produit)
    {
        $produitData = array(
            'nom' => $produit->getNom(),
            'prix' => $produit->getPrix(),
            'type' => $produit->getType(),
            'image' => $produit->getImage()
        );
        if ($produit->getId()) {
            $this->db->update('produits', $produitData, array('id' => $produit->getId()));
        }
        else {

            $this->db->insert('produits', $produitData);
            $last = $this->db->lastInsertId();
            return $this->find($last);
        }
    }


    /**
     * Deletes the produit.
     *
     * @param Produit $produit
     *
     * @return boolean
     */
    public function delete($produit)
    {
        return $this->db->delete('produits', array('id' => $produit->getId()));
    }
    /**
     * Returns the total number of produits.
     *
     * @return integer The total number of produits.
     */
    public function getCount() {
        return $this->db->fetchColumn('SELECT COUNT(id) FROM produits');
    }
    /**
     * Returns an produit matching the supplied id.
     *
     * @param integer $id
     *
     * @return User|false An entity object if found, false otherwise.
     */
    public function find($id)
    {
        $produitData = $this->db->fetchAssoc('SELECT * FROM produits WHERE id = ?', array($id));
        return $produitData ? $this->buildProduit($produitData) : FALSE;
    }


    /**
     * Returns a collection of produits, sorted by name.
     *
     * @param integer $limit
     *   The number of produit to return.
     * @param integer $offset
     *   The number of produit to skip.
     * @param array $orderBy
     *   Optionally, the order by info, in the $column => $direction format.
     *
     * @return array A collection of produit, keyed by like id.
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
                ->from('produits', 'r')
                ->setMaxResults($limit)
                ->setFirstResult($offset)
                ->orderBy('r.' . key($orderBy), current($orderBy));
        }else {
            $queryBuilder
                ->select('r.*')
                ->from('produits', 'r')
                ->setFirstResult($offset)
                ->orderBy('r.' . key($orderBy), current($orderBy));
        }
        $statement = $queryBuilder->execute();
        $produitsData = $statement->fetchAll();
        $likes = array();
        foreach ($produitsData as $produitData) {
            $likeId = $produitData['id'];
            $likes[$likeId] = $this->buildProduit($produitData);
        }
        return $likes;
    }
    /**
     * Instantiates an produit entity and sets its properties using db data.
     *
     * @param array $produitData
     *   The array of db data.
     *
     * @return Produit
     */
    protected function buildProduit($produitData)
    {
        $produit = new Produit();
        $produit->setId($produitData['id']);
        $produit->setNom($produitData['nom']);
        $produit->setPrix($produitData['prix']);
        $produit->setType($produitData['type']);
        $produit->setImage($produitData['image']);

        return $produit;
    }

}