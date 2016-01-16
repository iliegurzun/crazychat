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
    private $username;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $referral;

    /**
     * @var \Duedinoi\UserBundle\Entity\User
     */
    private $recruiter;

    /**
     * @var \Duedinoi\UserBundle\Entity\User
     */
    private $converter;

    public function __toString()
    {
        return $this->getUsername();
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
     * Set username
     *
     * @param string $username
     *
     * @return RecruitedMember
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
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
     * Set referral
     *
     * @param string $referral
     *
     * @return RecruitedMember
     */
    public function setReferral($referral)
    {
        $this->referral = $referral;

        return $this;
    }

    /**
     * Get referral
     *
     * @return string
     */
    public function getReferral()
    {
        return $this->referral;
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
}
