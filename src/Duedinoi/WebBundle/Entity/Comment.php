<?php

namespace Duedinoi\WebBundle\Entity;

/**
 * Comment
 */
class Comment
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var boolean
     */
    private $status;

    /**
     * @var string
     */
    private $content;
    
    /**
     * @var \Duedinoi\UserBundle\Entity\User
     */
    private $author;

    /**
     * @var \Duedinoi\UserBundle\Entity\User
     */
    private $user;
    
    const STATUS_ACTIVE = 1;
    
    const STATUS_INACTIVE = 0;

    public function __construct()
    {
        $this->status = self::STATUS_ACTIVE;
    }
    
    public function __toString() 
    {
        return $this->getContent();
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Comment
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
     * @return Comment
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
     * Set status
     *
     * @param boolean $status
     *
     * @return Comment
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Comment
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
    
    /**
     * Set author
     *
     * @param \Duedinoi\UserBundle\Entity\User $author
     *
     * @return Comment
     */
    public function setAuthor(\Duedinoi\UserBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \Duedinoi\UserBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set user
     *
     * @param \Duedinoi\UserBundle\Entity\User $user
     *
     * @return Comment
     */
    public function setUser(\Duedinoi\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Duedinoi\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
