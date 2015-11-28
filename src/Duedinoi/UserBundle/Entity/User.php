<?php

namespace Duedinoi\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Duedinoi\UserBundle\Entity\Profile;
use Duedinoi\WebBundle\Entity\Comment;
use FOS\MessageBundle\Model\ParticipantInterface;

//use Doctrine\ORM\Mapping\Annotation as ORM;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 */
class User extends BaseUser implements ParticipantInterface 
{

    /**
     * @var integer
     */
    protected $id;
    
    /**
     * @var \Duedinoi\UserBundle\Entity\Profile
     */
    private $profile;
    
    /**
     * @var \DateTime
     */
    private $lastActivityAt;

    /**
     * @var \Duedinoi\AdminBundle\Entity\Country
     */
    private $country;
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $comments;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $receivedComments;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $threads;
    
    /**
     * @var string
     */
    private $slug;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $photos;
    
    public function __construct() {
        parent::__construct();
        $this->profile = new Profile();
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->receivedComments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->threads = new \Doctrine\Common\Collections\ArrayCollection();
        $this->photos = new \Doctrine\Common\Collections\ArrayCollection();
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
        return $this->getUsername();
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

    /**
     * Set lastActivityAt
     *
     * @param \DateTime $lastActivityAt
     *
     * @return User
     */
    public function setLastActivityAt($lastActivityAt)
    {
        $this->lastActivityAt = $lastActivityAt;

        return $this;
    }

    /**
     * Get lastActivityAt
     *
     * @return \DateTime
     */
    public function getLastActivityAt()
    {
        return $this->lastActivityAt;
    }
    
    /**
     * @return Bool Whether the user is active or not
     */
    public function isActiveNow()
    {
        // Delay during wich the user will be considered as still active
        $delay = new \DateTime('2 minutes ago');

        return ( $this->getLastActivityAt() > $delay );
    }

    /**
     * Add comment
     *
     * @param \Duedinoi\WebBundle\Entity\Comment $comment
     *
     * @return User
     */
    public function addComment(\Duedinoi\WebBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \Duedinoi\WebBundle\Entity\Comment $comment
     */
    public function removeComment(\Duedinoi\WebBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add receivedComment
     *
     * @param \Duedinoi\WebBundle\Entity\Comment $receivedComment
     *
     * @return User
     */
    public function addReceivedComment(\Duedinoi\WebBundle\Entity\Comment $receivedComment)
    {
        $this->receivedComments[] = $receivedComment;

        return $this;
    }

    /**
     * Remove receivedComment
     *
     * @param \Duedinoi\WebBundle\Entity\Comment $receivedComment
     */
    public function removeReceivedComment(\Duedinoi\WebBundle\Entity\Comment $receivedComment)
    {
        $this->receivedComments->removeElement($receivedComment);
    }

    /**
     * Get receivedComments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReceivedComments()
    {
        return $this->receivedComments;
    }
    
    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return User
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
    
    public function getActiveComments()
    {
        $activeComments = $this->getReceivedComments()->filter(function($item) {
            return Comment::STATUS_ACTIVE == $item->getStatus();
        });

        return $activeComments;
    }
    
    /**
     * Add photo
     *
     * @param \Duedinoi\AdminBundle\Entity\Image $photo
     *
     * @return User
     */
    public function addPhoto(\Duedinoi\AdminBundle\Entity\Image $photo)
    {
        $this->photos[] = $photo;

        return $this;
    }

    /**
     * Remove photo
     *
     * @param \Duedinoi\AdminBundle\Entity\Image $photo
     */
    public function removePhoto(\Duedinoi\AdminBundle\Entity\Image $photo)
    {
        $this->photos->removeElement($photo);
    }

    /**
     * Get photos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPhotos()
    {
        return $this->photos;
    }
    
    public function hasProfilePicture()
    {
        /* @var $photo \Duedinoi\AdminBundle\Entity\Image */
        foreach ($this->getPhotos() as $photo) {
            if ($photo->getIsProfilePicture()) {
                return true;
            }
        }
        
        return false;
    }
    
    public function getProfilePicture()
    {
        foreach ($this->getPhotos() as $photo) {
            if ($photo->getIsProfilePicture()) {
                return $photo;
            }
        }
        
        return;
    }

    /**
     * Add thread
     *
     * @param \Duedinoi\WebBundle\Entity\Thread $thread
     *
     * @return User
     */
    public function addThread(\Duedinoi\WebBundle\Entity\Thread $thread)
    {
        $this->threads[] = $thread;

        return $this;
    }

    /**
     * Remove thread
     *
     * @param \Duedinoi\WebBundle\Entity\Thread $thread
     */
    public function removeThread(\Duedinoi\WebBundle\Entity\Thread $thread)
    {
        $this->threads->removeElement($thread);
    }

    /**
     * Get threads
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getThreads()
    {
        return $this->threads;
    }
    
    public function isSameUser($user)
    {
        return $this === $user;
    }
}