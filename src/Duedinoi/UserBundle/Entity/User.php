<?php

namespace Duedinoi\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Duedinoi\UserBundle\Entity\Profile;
use Duedinoi\WebBundle\Entity\Comment;
use FOS\MessageBundle\Model\ParticipantInterface;
use Cunningsoft\ChatBundle\Entity\AuthorInterface;
//use Doctrine\ORM\Mapping\Annotation as ORM;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 */
class User extends BaseUser implements AuthorInterface 
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
     * @var string
     */
    private $slug;
    
    /**
     * @var string
     */
    private $ipAddress;

    /**
     * @var string
     */
    private $converter;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $updated_at;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $photos;
    
    /**
     * @var string
     */
    private $referral;

    /**
     * @var string
     */
    private $site;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $recruitedUsers;

    /**
     * @var \Duedinoi\UserBundle\Entity\User
     */
    private $recruiter;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $likedUsers;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $blockUsers;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $userLikes;
    
    public function __construct() {
        parent::__construct();
        if (!$this->profile) {
            $profile = new Profile();
            $this->setProfile($profile);
        }
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->receivedComments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->photos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->userLikes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->likedUsers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->blockUsers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->userBlocks = new \Doctrine\Common\Collections\ArrayCollection();
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
        $profile->setUser($this);

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
        if ($this->getProfile() instanceof Profile) {
            return $this->getProfile()->getAge();
        }
        
        return '';
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

    public function isSameUser($user)
    {
        return $this === $user;
    }
    
    public $role;
    
    public function getRole()
    {
        if (!empty($this->roles)) {
            return $this->roles[0];
        }
        
        return null;
    }

    public function setRole($role)
    {
        $this->roles = array($role);

        return $this;
    }

    public function hasRole($role = null) 
    {
        if ($role) {
            return in_array(strtoupper($role), $this->getRoles(), true);
        }
        
        return false;
    }
    
    public function getTypeString()
    {
        if ($this->hasRole('ROLE_SUPER_ADMIN')) {
            return 'Super Admin';
        }
        if ($this->hasRole('ROLE_ADMIN')) {
            return 'Admin';
        }
        if ($this->hasRole('ROLE_BOT')) {
            return 'Robot';
        }
        
        return 'User';
    }
    
    /**
     * Set ipAddress
     *
     * @param string $ipAddress
     *
     * @return User
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    /**
     * Get ipAddress
     *
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }
    
    public function getGenderAdmin()
    {
        if ($this->getProfile()->getGender() === Profile::GENDER_FEMALE) {
            return 'F';
        }
        
        return 'M';
    }
    
    
    /**
     * Set referral
     *
     * @param string $referral
     *
     * @return User
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
     * Set converter
     *
     * @param string $converter
     *
     * @return User
     */
    public function setConverter($converter)
    {
        $this->converter = $converter;

        return $this;
    }

    /**
     * Get converter
     *
     * @return string
     */
    public function getConverter()
    {
        return $this->converter;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return User
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set site
     *
     * @param string $site
     *
     * @return User
     */
    public function setSite($site)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * Get site
     *
     * @return string
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Add recruitedUser
     *
     * @param \Duedinoi\UserBundle\Entity\User $recruitedUser
     *
     * @return User
     */
    public function addRecruitedUser(\Duedinoi\UserBundle\Entity\User $recruitedUser)
    {
        $this->recruitedUsers[] = $recruitedUser;

        return $this;
    }

    /**
     * Remove recruitedUser
     *
     * @param \Duedinoi\UserBundle\Entity\User $recruitedUser
     */
    public function removeRecruitedUser(\Duedinoi\UserBundle\Entity\User $recruitedUser)
    {
        $this->recruitedUsers->removeElement($recruitedUser);
    }

    /**
     * Get recruitedUsers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecruitedUsers()
    {
        return $this->recruitedUsers;
    }

    /**
     * Set recruiter
     *
     * @param \Duedinoi\UserBundle\Entity\User $recruiter
     *
     * @return User
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
     * Add likedUser
     *
     * @param \Duedinoi\WebBundle\Entity\UserLike $likedUser
     *
     * @return User
     */
    public function addLikedUser(\Duedinoi\WebBundle\Entity\UserLike $likedUser)
    {
        $this->likedUsers[] = $likedUser;

        return $this;
    }

    /**
     * Remove likedUser
     *
     * @param \Duedinoi\WebBundle\Entity\UserLike $likedUser
     */
    public function removeLikedUser(\Duedinoi\WebBundle\Entity\UserLike $likedUser)
    {
        $this->likedUsers->removeElement($likedUser);
    }

    /**
     * Get likedUsers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLikedUsers()
    {
        return $this->likedUsers;
    }

    /**
     * Add userLike
     *
     * @param \Duedinoi\WebBundle\Entity\UserLike $userLike
     *
     * @return User
     */
    public function addUserLike(\Duedinoi\WebBundle\Entity\UserLike $userLike)
    {
        $this->userLikes[] = $userLike;

        return $this;
    }

    /**
     * Remove userLike
     *
     * @param \Duedinoi\WebBundle\Entity\UserLike $userLike
     */
    public function removeUserLike(\Duedinoi\WebBundle\Entity\UserLike $userLike)
    {
        $this->userLikes->removeElement($userLike);
    }
    
    public function likesUser(User $user)
    {
        $likes = $this->getLikedUsers()->filter(function($item) use ($user) {
            if ($item->getToUser() === $user)  {
                return $item;
            }
        });
        
        /* @var $like \Duedinoi\WebBundle\Entity\UserLike */
        foreach ($likes as $like) {
            if (\Duedinoi\WebBundle\Entity\UserLike::LIKE === $like->getStatus()) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Get userLikes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserLikes()
    {
        return $this->userLikes;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $userBlocks;


    /**
     * Add blockUser
     *
     * @param \Duedinoi\WebBundle\Entity\BlockComment $blockUser
     *
     * @return User
     */
    public function addBlockUser(\Duedinoi\WebBundle\Entity\BlockComment $blockUser)
    {
        $this->blockUsers[] = $blockUser;

        return $this;
    }

    /**
     * Remove blockUser
     *
     * @param \Duedinoi\WebBundle\Entity\BlockComment $blockUser
     */
    public function removeBlockUser(\Duedinoi\WebBundle\Entity\BlockComment $blockUser)
    {
        $this->blockUsers->removeElement($blockUser);
    }

    /**
     * Get blockUsers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBlockUsers()
    {
        return $this->blockUsers;
    }

    /**
     * Add userBlock
     *
     * @param \Duedinoi\WebBundle\Entity\BlockComment $userBlock
     *
     * @return User
     */
    public function addUserBlock(\Duedinoi\WebBundle\Entity\BlockComment $userBlock)
    {
        $this->userBlocks[] = $userBlock;

        return $this;
    }

    /**
     * Remove userBlock
     *
     * @param \Duedinoi\WebBundle\Entity\BlockComment $userBlock
     */
    public function removeUserBlock(\Duedinoi\WebBundle\Entity\BlockComment $userBlock)
    {
        $this->userBlocks->removeElement($userBlock);
    }

    /**
     * Get userBlocks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserBlocks()
    {
        return $this->userBlocks;
    }
    
    public function blocksUser(User $user)
    {
        $blocks = $this->getBlockUsers()->filter(function($item) use ($user) {
            if ($item->getToUser() === $user)  {
                return $item;
            }
        });
        
        return $blocks->count() > 0;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $reportUsers;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $userReports;


    /**
     * Add reportUser
     *
     * @param \Duedinoi\WebBundle\Entity\ProfileReport $reportUser
     *
     * @return User
     */
    public function addReportUser(\Duedinoi\WebBundle\Entity\ProfileReport $reportUser)
    {
        $this->reportUsers[] = $reportUser;

        return $this;
    }

    /**
     * Remove reportUser
     *
     * @param \Duedinoi\WebBundle\Entity\ProfileReport $reportUser
     */
    public function removeReportUser(\Duedinoi\WebBundle\Entity\ProfileReport $reportUser)
    {
        $this->reportUsers->removeElement($reportUser);
    }

    /**
     * Get reportUsers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReportUsers()
    {
        return $this->reportUsers;
    }

    /**
     * Add userReport
     *
     * @param \Duedinoi\WebBundle\Entity\ProfileReport $userReport
     *
     * @return User
     */
    public function addUserReport(\Duedinoi\WebBundle\Entity\ProfileReport $userReport)
    {
        $this->userReports[] = $userReport;

        return $this;
    }

    /**
     * Remove userReport
     *
     * @param \Duedinoi\WebBundle\Entity\ProfileReport $userReport
     */
    public function removeUserReport(\Duedinoi\WebBundle\Entity\ProfileReport $userReport)
    {
        $this->userReports->removeElement($userReport);
    }

    /**
     * Get userReports
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserReports()
    {
        return $this->userReports;
    }
    
    public function hasBeenReported()
    {
        return $this->userReports->count() > 0;
    }
}
