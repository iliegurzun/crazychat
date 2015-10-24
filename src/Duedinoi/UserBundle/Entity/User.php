<?php

namespace Duedinoi\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Duedinoi\UserBundle\Entity\Profile;

//use Doctrine\ORM\Mapping\Annotation as ORM;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 */
class User extends BaseUser {

    /**
     * @var integer
     */
    protected $id;
    
    /**
     * @var \Duedinoi\UserBundle\Entity\Profile
     */
    private $profile;

    /**
     * @var \Duedinoi\AdminBundle\Entity\Country
     */
    private $country;

    public function __construct() {
        parent::__construct();
        $this->profile = new Profile();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set profile
     *
     * @param \Duedinoi\UserBundle\Entity\Profile $profile
     * @return User
     */
    public function setProfile(\Duedinoi\UserBundle\Entity\Profile $profile = null) {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get profile
     *
     * @return \Duedinoi\UserBundle\Entity\Profile 
     */
    public function getProfile() {
        return $this->profile;
    }

    public function __toString() {
        return $this->getProfile()->getName();
    }

    /**
     * Get the full name of the user (first + last name)
     * @return string
     */
    public function getFullName() {
        return $this->profile->getFirstName() . ' ' . $this->profile->getLastName();
    }

    public function getAge()
    {
        return $this->getProfile()->getAge();
    }

    /**
     * Set country
     *
     * @param \Duedinoi\AdminBundle\Entity\Country $country
     *
     * @return User
     */
    public function setCountry(\Duedinoi\AdminBundle\Entity\Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \Duedinoi\AdminBundle\Entity\Country
     */
    public function getCountry()
    {
        return $this->country;
    }
}
