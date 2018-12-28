<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

//Use some constraints to control what is put in the form.
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 * fields = {"pseudo"},
 * message="The pseudonym is already used in the database.")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=2, max= 255)
     */
    private $name;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\length(min=2, max= 255)
     */
    private $surname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=2, max= 255)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8", max= 255, minMessage="Your password must be at least 8 characters")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\EqualTo(propertyPath="comfirmPassword", message=" Your password must be the same as the previous one")
     */
    private $comfirmPassword;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ListOfTasks", mappedBy="users")
     */
    private $listCreated;

    public function __construct()
    {
        $this->listCreated = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

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

    public function getComfirmPassword(): ?string
    {
        return $this->comfirmPassword;
    }

    public function setComfirmPassword(string $comfirmPassword): self
    {
        $this->comfirmPassword = $comfirmPassword;

        return $this;
    }

    /**
     * @return Collection|ListOfTasks[]
     */
    public function getListCreated(): Collection
    {
        return $this->listCreated;
    }

    public function addListCreated(ListOfTasks $listCreated): self
    {
        if (!$this->listCreated->contains($listCreated)) {
            $this->listCreated[] = $listCreated;
            $listCreated->setUsers($this);
        }

        return $this;
    }

    public function removeListCreated(ListOfTasks $listCreated): self
    {
        if ($this->listCreated->contains($listCreated)) {
            $this->listCreated->removeElement($listCreated);
            // set the owning side to null (unless already changed)
            if ($listCreated->getUsers() === $this) {
                $listCreated->setUsers(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return (string) $this->name;
    }

    //Functions implemented with using UserInterface Components.
    public function eraseCredentials()
    {

    }

    public function getSalt()
    {

    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getUsername(): ?string
    {
        return $this->name;
    }
}
