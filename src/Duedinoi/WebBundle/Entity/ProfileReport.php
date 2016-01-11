<?php

namespace Duedinoi\WebBundle\Entity;

/**
 * ProfileReport
 */
class ProfileReport
{
    /**
     * @var integer
     */
    private $id;


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
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;


    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return ProfileReport
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
     * @return ProfileReport
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
     * @var \Duedinoi\UserBundle\Entity\User
     */
    private $fromUser;

    /**
     * @var \Duedinoi\UserBundle\Entity\User
     */
    private $toUser;


    /**
     * Set fromUser
     *
     * @param \Duedinoi\UserBundle\Entity\User $fromUser
     *
     * @return ProfileReport
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
     * @return ProfileReport
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
