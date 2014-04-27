<?php

namespace Iog\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Iog\UserBundle\Entity\Profile;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 */
class User extends BaseUser
{
    /**
     * @var integer
     */
    protected $id;


    public function __construct() {
        parent::__construct();
        $this->profile = new Profile();
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
    
    public function setEmail($email) {
        parent::setEmail($email);
        $this->username = $email;
        $this->usernameCanonical = $email;
        
        return $this;
    }
    /**
     * @var \Iog\UserBundle\Entity\Profile
     */
    private $profile;


    /**
     * Set profile
     *
     * @param \Iog\UserBundle\Entity\Profile $profile
     * @return User
     */
    public function setProfile(\Iog\UserBundle\Entity\Profile $profile = null)
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get profile
     *
     * @return \Iog\UserBundle\Entity\Profile 
     */
    public function getProfile()
    {
        return $this->profile;
    }
    
    public function __toString() {
        return $this->profile->getFirstName() . ' ' . $this->profile->getLastName();
    }
}
