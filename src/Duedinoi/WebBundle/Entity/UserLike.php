<?php

namespace Duedinoi\WebBundle\Entity;

/**
 * UserLike
 */
class UserLike
{
    const LIKE = 1;
    
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $status;


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
     * @return UserLike
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return UserLike
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
     * @return UserLike
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
     * @return UserLike
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
     * @return UserLike
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
}
