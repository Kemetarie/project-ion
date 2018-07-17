<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 16/07/2018
 * Time: 12:05
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity="Ad", mappedBy="category")
     */
    private $ad;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Category
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * @param mixed $libelle
     * @return Category
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAd()
    {
        return $this->ad;
    }

    /**
     * @param mixed $ad
     * @return Category
     */
    public function setAd($ad)
    {
        $this->ad = $ad;

        return $this;
    }

    public function __toString()
    {
        return $this->getLibelle();
    }


}