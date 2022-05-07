<?php


namespace App\Models;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;

/**
 * Class Message
* @Entity @ORM\Table(name="messages")
 *@ORM\Entity(repositoryClass="App\Repositories\MessageRepository")
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $sender;

    /**
     * @ORM\Column(type="integer")
     */
    private $receive;

    /**
     * @ORM\Column(type="text")
     */
    private $message;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getSender(): int
    {
        return $this->sender;
    }

    /**
     * @return int
     */
    public function getReceive(): int
    {
        return $this->receive;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param int $id
     * @return Message
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param int $sender
     * @return Message
     */
    public function setSender(int $sender): self
    {
        $this->sender = $sender;
        return $this;
    }

    /**
     * @param int $receive
     * @return Message
     */
    public function setReceive(int $receive): self
    {
        $this->receive = $receive;
        return $this;
    }

    /**
     * @param string $message
     * @return Message
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

}