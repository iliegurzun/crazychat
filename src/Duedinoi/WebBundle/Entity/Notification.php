<?php

namespace Duedinoi\WebBundle\Entity;

/**
 * Notification
 */
class Notification
{
    const STATUS_UNREAD = 0;
    
    const STATUS_READ = 1;
    
    const STATUS_DELETED = -1;
    
    const LIKE_PHOTO = 1;
    
    const COMMENT_PHOTO = 2;
    
    const FAVORITE_PROFILE = 3;
    
    const VIEW_PROFILE = 4;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var string
     */
    private $type;
    
    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var \Duedinoi\UserBundle\Entity\User
     */
    private $fromUser;

    /**
     * @var \Duedinoi\UserBundle\Entity\User
     */
    private $toUser;

    /**
     * @var \Duedinoi\AdminBundle\Entity\Image
     */
    private $photo;

    /**
     * @var \Duedinoi\WebBundle\Entity\Comment
     */
    private $comment;


    public function __construct() 
    {
        $this->setStatus(self::STATUS_UNREAD);
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Notification
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Notification
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Notification
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Notification
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set fromUser
     *
     * @param \Duedinoi\UserBundle\Entity\User $fromUser
     *
     * @return Notification
     */
    public function setFromUser(\Duedinoi\UserBundle\Entity\User $fromUser = null)
    {
        $this->fromUser = $fromUser;

        return $this;
    }

    /**
     * Get fromUser
     *
     * @return \Duedinoi\UserBundle\Entity\User
     */
    public function getFromUser()
    {
        return $this->fromUser;
    }

    /**
     * Set toUser
     *
     * @param \Duedinoi\UserBundle\Entity\User $toUser
     *
     * @return Notification
     */
    public function setToUser(\Duedinoi\UserBundle\Entity\User $toUser = null)
    {
        $this->toUser = $toUser;

        return $this;
    }

    /**
     * Get toUser
     *
     * @return \Duedinoi\UserBundle\Entity\User
     */
    public function getToUser()
    {
        return $this->toUser;
    }

    /**
     * Set photo
     *
     * @param \Duedinoi\AdminBundle\Entity\Image $photo
     *
     * @return Notification
     */
    public function setPhoto(\Duedinoi\AdminBundle\Entity\Image $photo = null)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return \Duedinoi\AdminBundle\Entity\Image
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set comment
     *
     * @param \Duedinoi\WebBundle\Entity\Comment $comment
     *
     * @return Notification
     */
    public function setComment(\Duedinoi\WebBundle\Entity\Comment $comment = null)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return \Duedinoi\WebBundle\Entity\Comment
     */
    public function getComment()
    {
        return $this->comment;
    }
}
