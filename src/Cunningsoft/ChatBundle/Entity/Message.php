<?php

namespace Cunningsoft\ChatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Cunningsoft\ChatBundle\Repository\MessageRepository")
 * @ORM\Table(name="ChatMessage")
 */
class Message
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var AuthorInterface
     *
     * @ORM\ManyToOne(targetEntity="AuthorInterface")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;
    
    /**
     * @var AuthorInterface
     *
     * @ORM\ManyToOne(targetEntity="AuthorInterface")
     * @ORM\JoinColumn(nullable=false)
     */
    private $receiver;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $channel;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $message;
    
    /**
     * @var string
     *
     * @ORM\Column(type="boolean")
     */
    private $isMass = false;
    
    private $receivers;

    /**
     * @var string
     *
     * @ORM\Column(type="boolean")
     */
    private $isRead = false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $insertDate;
    
    public function __construct()
    {
        $this->isMass = false;
        $this->isRead = false;
        $this->receivers = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param AuthorInterface $author
     */
    public function setAuthor(AuthorInterface $author)
    {
        $this->author = $author;
        
        return $this;
    }

    /**
     * @param string $content
     */
    public function setMessage($content)
    {
        $this->message = $content;
        
        return $this;
    }

    /**
     * @param string $channel
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;
        
        return $this;
    }

    /**
     * @param \DateTime $insertDate
     */
    public function setInsertDate($insertDate)
    {
        $this->insertDate = $insertDate;
        
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getInsertDate()
    {
        return $this->insertDate;
    }

    /**
     * @return AuthorInterface
     */
    public function getAuthor()
    {
        return $this->author;
    }
    
    public function getReceiver()
    {
        return $this->receiver;
    }
    
    public function setReceiver(AuthorInterface $receiver)
    {
        $this->receiver = $receiver;
        
        return $this;
    }
    
    public function getIsMass()
    {
        return $this->isMass;
    }
    
    public function setIsMass($isMass)
    {
        $this->isMass = $isMass;
        
        return $this;
    }
    
    public function getReceivers()
    {
        return $this->receivers;
    }
    
    public function addReceiver($receiver)
    {
        $this->receivers[] = $receiver;
        
        return $this;
    }
    
    public function canBeRemoved($user)
    {
        return $this->getAuthor() == $user;
    }

    /**
     * Get channel
     *
     * @return string
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * Set isRead
     *
     * @param boolean $isRead
     *
     * @return Message
     */
    public function setIsRead($isRead)
    {
        $this->isRead = $isRead;

        return $this;
    }

    /**
     * Get isRead
     *
     * @return boolean
     */
    public function getIsRead()
    {
        return $this->isRead;
    }
}
