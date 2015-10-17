<?php

namespace Duedinoi\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Duedinoi\UserBundle\Entity\Profile;

use Doctrine\ORM\Mapping\Annotation as ORM;
//use Doctrine\ORM\Mapping as ORM;

/**
 * User
 */
class User extends BaseUser {

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
    public function getId() {
        return $this->id;
    }

    public function setEmail($email) {
        parent::setEmail($email);
        $this->username = $email;
        $this->usernameCanonical = $email;

        return $this;
    }

    /**
     * @var \Duedinoi\UserBundle\Entity\Profile
     */
    private $profile;

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
        return $this->profile->getFirstName() . ' ' . $this->profile->getLastName();
    }

    public function serialize() {
        return serialize(array($this->facebookId, parent::serialize()));
    }

    public function unserialize($data) {
        list($this->facebookId, $parentData) = unserialize($data);
        parent::unserialize($parentData);
    }

    /**
     * Get the full name of the user (first + last name)
     * @return string
     */
    public function getFullName() {
        return $this->profile->getFirstName() . ' ' . $this->profile->getLastName();
    }

    /**
     * <a href="/param">@param</a> string $facebookId
     * @return void
     */
    public function setFacebookId($facebookId) {
        $this->facebookId = $facebookId;
    }

    /**
     * @return string
     */
    public function getFacebookId() {
        return $this->facebookId;
    }

    /**
     * <a href="/param">@param</a> Array
     */
    public function setFBData($fbdata) {
        
        if (isset($fbdata['id'])) {
            $this->setFacebookId($fbdata['id']);
            $this->addRole('ROLE_USER');
        }
        if (isset($fbdata['first_name'])) {
            $this->profile->setFirstname($fbdata['first_name']);
        }
        if (isset($fbdata['last_name'])) {
            $this->profile->setLastname($fbdata['last_name']);
        }
        if (isset($fbdata['email'])) {
            $this->setEmail($fbdata['email']);
        }
    }

    /**
     * @var string
     */
    private $facebookId;

    public function getAge()
    {
        return $this->getProfile()->getAge();
    }
}
