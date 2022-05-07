<?php


namespace App\Models;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Zgeniuscoders\Zgeniuscoders\Auth\User as UserInterface;


/**
 * Class User
 * @Entity @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="App\Repositories\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $uuid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $profile;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    private $created;

    public function getId()
    {
        return $this->id;
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getProfile()
    {
        return $this->profile;
    }

    public function getCreated(): DateTime
    {
        return $this->created;
    }

    /**
     * @param string $uuid
     * @return User
     */
    public function setUuid(string $uuid) : self
    {
        $this->uuid = $uuid;

        return $this;

    }

    /**
     * @param string $name
     * @return User
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $pseudo
     * @return User
     */
    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;

    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;

    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;

    }

    /**
     * @param string $profile
     * @return User
     */
    public function setProfile(string $profile): self
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * @param DateTime $created
     * @return User
     */
    public function setCreated(DateTime $created): self
    {
        $this->created = $created;

        return $this;
    }
}