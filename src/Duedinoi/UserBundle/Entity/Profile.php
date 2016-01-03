<?php

namespace Duedinoi\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Profile
 */
class Profile
{
    /** const int */
    const GENDER_MALE = 0;

    /** const int */
    const GENDER_FEMALE = 1;
    
    const STATUS_SINGLE = 'single';
    
    const STATUS_MARRIED = 'married';
    
    const STATUS_DIVORCED = 'divorced';
    
    const STATUS_ENGAGED = 'engaged';
    
    const STATUS_SEPARATED = 'separated';
    
    const STATUS_WIDOWED = 'widowed';
    
    const STATUS_IN_A_RELATIONSHIP = 'relationship';
    
    public static $relationshipsString = array(
        self::STATUS_SINGLE             => 'relationship.single',
        self::STATUS_MARRIED            => 'relationship.married',
        self::STATUS_DIVORCED           => 'relationship.divorced',
        self::STATUS_ENGAGED            => 'relationship.engaged',
        self::STATUS_SEPARATED          => 'relationship.separated',
        self::STATUS_WIDOWED            => 'relationship.widowed',
        self::STATUS_IN_A_RELATIONSHIP  => 'relationship.relationship',
    );
    
    public static $gendersString = array(
        self::GENDER_MALE   => 'gender.male',
        self::GENDER_FEMALE => 'gender.female'
    );
    
    public static $signString = array(
        self::SIGN_ARIES => 'sign.aries',
        self::SIGN_TAURUS => 'sign.taurus',
        self::SIGN_GEMINI => 'sign.gemini',
        self::SIGN_CANCER => 'sign.cancer',
        self::SIGN_LEO => 'sign.leo',
        self::SIGN_VIRGO => 'sign.virgo',
        self::SIGN_LIBRA => 'sign.libra',
        self::SIGN_SCORPIO => 'sign.scorpio',
        self::SIGN_SAGITTARIUS => 'sign.sagittarius',
        self::SIGN_CAPRICORN => 'sign.capricorn',
        self::SIGN_AQUARIUS => 'sign.aquarius',
        self::SIGN_PISCES => 'sign.pisces'
    );

    const SIGN_ARIES = 'aries';
    
    const SIGN_TAURUS = 'taurus';
    
    const SIGN_GEMINI = 'gemini';
    
    const SIGN_CANCER = 'cancer';
    
    const SIGN_LEO = 'leo';
    
    const SIGN_VIRGO = 'virgo';
    
    const SIGN_LIBRA = 'libra';
    
    const SIGN_SCORPIO = 'scorpio';
    
    const SIGN_SAGITTARIUS = 'sagittarius';
    
    const SIGN_CAPRICORN = 'capricorn';
    
    const SIGN_AQUARIUS = 'aquarius';
    
    const SIGN_PISCES = 'pisces';
    
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var integer
     */
    protected $gender;

    /**
     * @var \DateTime
     */
    protected $dateOfBirth;
    
    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $relationship;

    /**
     * @var string
     */
    private $sign;

    /**
     * @var string
     */
    private $hobby;

    /**
     * @var string
     */
    private $studies;

    /**
     * @var string
     */
    private $description;
    
    /**
     * @var \Duedinoi\AdminBundle\Entity\Image
     */
    protected $image;
    
    /**
     * @var boolean
     */
    private $voteNotification;

    /**
     * @var boolean
     */
    private $commentNotification;

    /**
     * @var boolean
     */
    private $messageNotification;
    
    /**
     * @var \Duedinoi\UserBundle\Entity\User
     */
    private $user;

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
     * Set gender
     *
     * @param integer $gender
     * @return Profile
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return integer 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set image
     *
     * @param \Duedinoi\AdminBundle\Entity\Image $image
     * @return Profile
     */
    public function setImage(\Duedinoi\AdminBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Duedinoi\AdminBundle\Entity\Image 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set dateOfBirth
     *
     * @param \DateTime $dateOfBirth
     *
     * @return Profile
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * Get dateOfBirth
     *
     * @return \DateTime
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    public function getAge()
    {
        if (!$this->getDateOfBirth()) {
            return;
        }
        $now = new \DateTime();
        $age = $now->format('Y') - $this->getDateOfBirth()->format('Y');

        return $age;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Profile
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set relationship
     *
     * @param string $relationship
     *
     * @return Profile
     */
    public function setRelationship($relationship)
    {
        $this->relationship = $relationship;

        return $this;
    }

    /**
     * Get relationship
     *
     * @return string
     */
    public function getRelationship()
    {
        return $this->relationship;
    }

    /**
     * Set sign
     *
     * @param string $sign
     *
     * @return Profile
     */
    public function setSign($sign)
    {
        $this->sign = $sign;

        return $this;
    }

    /**
     * Get sign
     *
     * @return string
     */
    public function getSign()
    {
        return $this->sign;
    }

    /**
     * Set hobby
     *
     * @param string $hobby
     *
     * @return Profile
     */
    public function setHobby($hobby)
    {
        $this->hobby = $hobby;

        return $this;
    }

    /**
     * Get hobby
     *
     * @return string
     */
    public function getHobby()
    {
        return $this->hobby;
    }

    /**
     * Set studies
     *
     * @param string $studies
     *
     * @return Profile
     */
    public function setStudies($studies)
    {
        $this->studies = $studies;

        return $this;
    }

    /**
     * Get studies
     *
     * @return string
     */
    public function getStudies()
    {
        return $this->studies;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Profile
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * Set voteNotification
     *
     * @param boolean $voteNotification
     *
     * @return Profile
     */
    public function setVoteNotification($voteNotification)
    {
        $this->voteNotification = $voteNotification;

        return $this;
    }

    /**
     * Get voteNotification
     *
     * @return boolean
     */
    public function getVoteNotification()
    {
        return $this->voteNotification;
    }

    /**
     * Set commentNotification
     *
     * @param boolean $commentNotification
     *
     * @return Profile
     */
    public function setCommentNotification($commentNotification)
    {
        $this->commentNotification = $commentNotification;

        return $this;
    }

    /**
     * Get commentNotification
     *
     * @return boolean
     */
    public function getCommentNotification()
    {
        return $this->commentNotification;
    }

    /**
     * Set messageNotification
     *
     * @param boolean $messageNotification
     *
     * @return Profile
     */
    public function setMessageNotification($messageNotification)
    {
        $this->messageNotification = $messageNotification;

        return $this;
    }

    /**
     * Get messageNotification
     *
     * @return boolean
     */
    public function getMessageNotification()
    {
        return $this->messageNotification;
    }
    
    public function getRelationshipStatus()
    {
        if (isset(self::$relationshipsString[$this->getRelationship()])) {
            return self::$relationshipsString[$this->getRelationship()];
        }
        
        return;
    }
    
    public function getGenderString()
    {
        if (isset(self::$gendersString[$this->getGender()])) {
            return self::$gendersString[$this->getGender()];
        }
        
        return;
    }
    
    public function getSignString()
    {
        if (isset(self::$signString[$this->getSign()])) {
            return self::$signString[$this->getSign()];
        }
        
        return;
    }

    /**
     * Set user
     *
     * @param \Duedinoi\UserBundle\Entity\User $user
     *
     * @return Profile
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
