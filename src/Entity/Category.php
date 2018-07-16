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
}