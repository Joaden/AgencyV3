<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface,\Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Renvoi list de Role du User
     * return array('ROLE_USER')
     * @return (Role|string)
     */
    public function getRoles()
    {
        return ['ROLE_ADMIN'];
    }
    
    /**
     * Return salt used to encode the password
     * return null if password was not encoded
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Remove the sensitive data from te user
     * return array('ROLE_USER')
     * @return 
     */
    public function eraseCredentials()
    {
    
    }

    /**
     * String representation of object
     * @link 
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        // TODO serialize() method 
        return serialize([
            $this->id,
            $this->username,
            $this->password
        ]);
    }

     /**
     * Construct the object
     * @link 
     * @param string $serialized <p>
     * String representation object </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        // TODO unserialize() method
        list (
            $this->id,
            $this->username,
            $this->password
            ) = unserialize($serialized, ['allowed_classes' => false]);
    }
}
