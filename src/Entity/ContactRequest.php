<?php

namespace App\Entity;

use App\Repository\ContactRequestRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;



/**
 * @ORM\Entity(repositoryClass=ContactRequestRepository::class)
 */
class ContactRequest
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
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Posez votre question")
     */
    private $request;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createDate;

    /**
     * @Groups({"export"})
     * 
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="contactRequests")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Type(type="App\Entity\User")
     * @Assert\Valid
     */
    private $contactUser;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isOpen = true;

    public function __construct()
    {
        $this->setCreateDate(new DateTime());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRequest(): ?string
    {
        return $this->request;
    }

    public function setRequest(string $request): self
    {
        $this->request = $request;

        return $this;
    }

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->createDate;
    }

    public function setCreateDate(\DateTimeInterface $createDate): self
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * @Groups({"export"})
     */
    public function getCreateDateToString() : string
    {
        return $this->getCreateDate()->format('y-M-d-H:m:s');
    }

    public function getContactUser(): ?User
    {
        return $this->contactUser;
    }

    public function setContactUser(?User $contactUser): self
    {
        $this->contactUser = $contactUser;

        return $this;
    }

    public function getIsOpen(): ?bool
    {
        return $this->isOpen;
    }

    public function setIsOpen(bool $isOpen): self
    {
        $this->isOpen = $isOpen;

        return $this;
    }
}
