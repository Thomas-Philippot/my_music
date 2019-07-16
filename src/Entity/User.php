<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="le nom d'utilisateur ne peut être vide")
     * @Assert\Length(
     *     min="5", minMessage="le nom d'utilisateur doit faire plus de 5 caractère",
     *     max="50", maxMessage="le nom d'utilisateur ne doit pas faire plus de 50 caractères"
     * )
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

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
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="le prénom ne peut être vide")
     * @Assert\Length(
     *     min="4", minMessage="le prénom doit faire plus de 4 caractère",
     *     max="50", maxMessage="le prénom ne doit pas faire plus de 50 caractères"
     * )
     */
    private $firstName;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="le nom ne peut être vide")
     * @Assert\Length(
     *     min="4", minMessage="le nom doit faire plus de 4 caractère",
     *     max="50", maxMessage="le nom ne doit pas faire plus de 50 caractères"
     * )
     */
    private $lastName;

    /**
     * @var Avatar
     * @ORM\ManyToOne(targetEntity="Avatar", inversedBy="users")
     */
    private $avatar;

    public function getId()
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername()
    {
        return (string) $this->username;
    }

    public function setUsername(string $username)
    {
        $this->username = $username;

        return $this;
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

    public function setRoles(array $roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return User
     */
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return User
     */
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return Avatar
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param Avatar $avatar
     * @return User
     */
    public function setAvatar(Avatar $avatar)
    {
        $this->avatar = $avatar;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
