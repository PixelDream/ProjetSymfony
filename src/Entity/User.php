<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\ManyToMany(targetEntity: Property::class, inversedBy: 'favoritesUsers')]
    private Collection $favorites;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: property::class)]
    private Collection $createProperties;

    public function __construct()
    {
        $this->favorites = new ArrayCollection();
        $this->createProperties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        if ($password) {
            $this->password = $password;
        }

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection<int, property>
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(property $favorite): self
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites->add($favorite);
        }

        return $this;
    }

    public function removeFavorite(property $favorite): self
    {
        $this->favorites->removeElement($favorite);

        return $this;
    }

    /**
     * Return user roles for ChoiceField
     * @return array<string, string>
     */
    public function getRolesChoices(): array
    {
        return [
            'Utilisateur' => 'ROLE_USER',
            'Administrateur' => 'ROLE_ADMIN',
        ];
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection<int, property>
     */
    public function getCreateProperties(): Collection
    {
        return $this->createProperties;
    }

    /**
     * > This function adds a property to the createProperties collection if it doesn't already exist
     *
     * @param property $createProperty createProperty The property object that we want to add to the author.
     *
     * @return self The author object.
     */
    public function addCreateProperty(property $createProperty): self
    {
        if (!$this->createProperties->contains($createProperty)) {
            $this->createProperties->add($createProperty);
            $createProperty->setAuthor($this);
        }

        return $this;
    }

    /**
     * The function removes a property from the createProperties collection
     *
     * @param property $createProperty createProperty The property object that you want to remove from the collection.
     *
     * @return self The user is being returned.
     */
    public function removeCreateProperty(property $createProperty): self
    {
        if ($this->createProperties->removeElement($createProperty)) {
            // set the owning side to null (unless already changed)
            if ($createProperty->getAuthor() === $this) {
                $createProperty->setAuthor(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->fullName();
    }

    public function fullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }


}
