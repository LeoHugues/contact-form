<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;



/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"export"})
     * 
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message="Saisissez votre e-mail")
     * @Assert\Email(
     *     message = "L'email '{{ value }}' n'est pas un email valid."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Groups({"export"})
     * 
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Saisissez votre nom")
     */
    private $lastname;

    /**
     * @ORM\OneToMany(targetEntity=ContactRequest::class, mappedBy="contactUser", orphanRemoval=true)
     */
    private $contactRequests;

    public function __construct()
    {
        $this->contactRequests = new ArrayCollection();
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
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
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

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return Collection|ContactRequest[]
     */
    public function getContactRequests(): Collection
    {
        return $this->contactRequests;
    }

    public function addContactRequest(ContactRequest $contactRequest): self
    {
        if (!$this->contactRequests->contains($contactRequest)) {
            $this->contactRequests[] = $contactRequest;
            $contactRequest->setContactUser($this);
        }

        return $this;
    }

    public function removeContactRequest(ContactRequest $contactRequest): self
    {
        if ($this->contactRequests->removeElement($contactRequest)) {
            // set the owning side to null (unless already changed)
            if ($contactRequest->getContactUser() === $this) {
                $contactRequest->setContactUser(null);
            }
        }

        return $this;
    }
}
