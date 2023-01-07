<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 20, scale: 16)]
    private ?string $latitude = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 20, scale: 16)]
    private ?string $longitude = null;

    #[ORM\OneToMany(mappedBy: 'location', targetEntity: property::class)]
    private Collection $properties;

    public function __construct()
    {
        $this->properties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return Collection<int, property>
     */
    public function getProperties(): Collection
    {
        return $this->properties;
    }

    public function addProperty(property $property): self
    {
        if (!$this->properties->contains($property)) {
            $this->properties->add($property);
            $property->setLocation($this);
        }

        return $this;
    }

    public function removeProperty(property $property): self
    {
        if ($this->properties->removeElement($property)) {
            // set the owning side to null (unless already changed)
            if ($property->getLocation() === $this) {
                $property->setLocation(null);
            }
        }

        return $this;
    }
}
