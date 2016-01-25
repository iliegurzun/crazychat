<?php

namespace Duedinoi\AdminBundle\Entity;

/**
 * RecruitedMember
 */
class RecruitedMember
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $email;

    /**
     * @var \Duedinoi\UserBundle\Entity\User
     */
    private $recruiter;

    /**
     * @var \Duedinoi\UserBundle\Entity\User
     */
    private $converter;

    /**
     * @var string
     */
    private $siteUser;

    /**
     * @var integer
     */
    private $age;

    /**
     * @var string
     */
    private $location;

    /**
     * @var string
     */
    private $siteName;

    /**
     * @var string
     */
    private $comments;

    public function __toString()
    {
        return $this->getSiteUser();
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
     * Set email
     *
     * @param string $email
     *
     * @return RecruitedMember
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set recruiter
     *
     * @param \Duedinoi\UserBundle\Entity\User $recruiter
     *
     * @return RecruitedMember
     */
    public function setRecruiter(\Duedinoi\UserBundle\Entity\User $recruiter = null)
    {
        $this->recruiter = $recruiter;

        return $this;
    }

    /**
     * Get recruiter
     *
     * @return \Duedinoi\UserBundle\Entity\User
     */
    public function getRecruiter()
    {
        return $this->recruiter;
    }

    /**
     * Set converter
     *
     * @param \Duedinoi\UserBundle\Entity\User $converter
     *
     * @return RecruitedMember
     */
    public function setConverter(\Duedinoi\UserBundle\Entity\User $converter = null)
    {
        $this->converter = $converter;

        return $this;
    }

    /**
     * Get converter
     *
     * @return \Duedinoi\UserBundle\Entity\User
     */
    public function getConverter()
    {
        return $this->converter;
    }

    /**
     * Set siteUser
     *
     * @param string $siteUser
     *
     * @return RecruitedMember
     */
    public function setSiteUser($siteUser)
    {
        $this->siteUser = $siteUser;

        return $this;
    }

    /**
     * Get siteUser
     *
     * @return string
     */
    public function getSiteUser()
    {
        return $this->siteUser;
    }

    /**
     * Set age
     *
     * @param integer $age
     *
     * @return RecruitedMember
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set location
     *
     * @param string $location
     *
     * @return RecruitedMember
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set siteName
     *
     * @param string $siteName
     *
     * @return RecruitedMember
     */
    public function setSiteName($siteName)
    {
        $this->siteName = $siteName;

        return $this;
    }

    /**
     * Get siteName
     *
     * @return string
     */
    public function getSiteName()
    {
        return $this->siteName;
    }

    /**
     * Set comments
     *
     * @param string $comments
     *
     * @return RecruitedMember
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
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
     * @return RecruitedMember
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
     * @return RecruitedMember
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
}
