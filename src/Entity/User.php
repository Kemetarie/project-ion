<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 16/07/2018
 * Time: 14:25
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=50)
     */
    private $username;
    /**
     * @ORM\Column(type="string")
     */
    private $email;
    /**
     * @ORM\Column(type="string")
     */
    private $password;
    /**
     * @ORM\Column(type="array")
     */
    private $roles;
    /**
     * @ORM\Column(type="date")
     */
    private $dateRegistered;
    /**
     * @ORM\ManyToMany(targetEntity="Ad")
     * @ORM\JoinTable(  name="favourite",
     *                  joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *                  inverseJoinColumns={@ORM\JoinColumn(name="ad_id",referencedColumnName="id")})
     */
    private $favourite;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getUsername() 
    {
        return $this->username;
    }
    
    /**
     * @param mixed $username
     * @return User
     */
    public function setUsername($username) 
    {
        $this->username = $username;
        
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param mixed $roles
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateRegistered()
    {
        return $this->dateRegistered;
    }

    /**
     * @param mixed $dateRegistered
     * @return User
     */
    public function setDateRegistered($dateRegistered)
    {
        $this->dateRegistered = $dateRegistered;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFavourite()
    {
        return $this->favourite;
    }

    /**
     * @param mixed $favourite
     * @return User
     */
    public function setFavourite($favourite)
    {
        $this->favourite = $favourite;

        return $this;
    }
    
    public function addFavourite($favourite)
    {
        $this->favourite->add($favourite);
    }
    
    public function removeFavourite($favourite)
    {
        $this->favourite->removeElement($favourite);
    }
    
    public function hasFavourite($favourite)
    {
        return $this->favourite->contains($favourite);
    }

    public function eraseCredentials() {
        
    }

    public function getSalt() {
        
    }

}