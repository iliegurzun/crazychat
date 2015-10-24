<?php

namespace Duedinoi\AdminBundle\Entity;

/**
 * City
 */
class City
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
     * @var string
     */
    private $name;

    /**
     * @var \Duedinoi\AdminBundle\Entity\Country
     */
    private $country;


    /**
     * Set name
     *
     * @param string $name
     *
     * @return City
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set country
     *
     * @param \Duedinoi\AdminBundle\Entity\Country $country
     *
     * @return City
     */
    public function setCountry(\Duedinoi\AdminBundle\Entity\Country $country = null)
    {
        $this->country = $country;
        $country->addCity($this);

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
    
    public function __toString() 
    {
        return $this->getName();
    }
}
