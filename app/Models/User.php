<?php


namespace App\Models;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Zgeniuscoders\Zgeniuscoders\Database\Model\Model;

/**
 * Class User
 * @Entity @ORM\Table(name="users")
 */
class User extends Model
{
//    protected string $table = "users";

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
     * @ORM\Column(type="string",length=255)
     */
    private $password;

    #[ORM\Column(type: "datetime_immutable",options: ['default' => 'CURRENT_TIMESTAMP'])]
    private $created_at;

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

    public function getCreated_at()
    {
        return $this->created_at;
    }
}