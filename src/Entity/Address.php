<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AddressRepository")
 */
class Address
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
    private $city;

    /**
     * @Assert\Regex("/^[0-9]{5}$/")
     * @ORM\Column(type="string", length=10)
     */
    private $postal_code;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $address;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Property", mappedBy="options")
     */
    private $properties;

    public function __construct()
    {
        // new array pour initialiser la valeur
        $this->properties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postal_code;
    }

    public function setPostalCode(string $postal_code): self
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

     // 3 méthodes get add remove
    /**
     * @return Collection|Property[]
     */
    public function getProperties()
    {
        return $this->properties;
    }

    public function addProperty(Property $property): self
    {
        if (!$this->properties->contains($property)) {
            $this->properties[] = $property;
        }

        return $this;
    }

    public function removeProperty(Property $property): self
    {
        if ($this->properties->contains($property)) {
            $this->properties->removeElement($property);
        }

        return $this;
    }
}
