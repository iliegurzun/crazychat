<?php

namespace Duedinoi\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gallery
 */
class Gallery
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;


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
     * Set name
     *
     * @param string $name
     * @return Gallery
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $gallery_images;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->gallery_images = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add gallery_images
     *
     * @param \Duedinoi\AdminBundle\Entity\Image $galleryImages
     * @return Gallery
     */
    public function addGalleryImage(\Duedinoi\AdminBundle\Entity\Image $galleryImages)
    {
        $this->gallery_images[] = $galleryImages;

        return $this;
    }

    /**
     * Remove gallery_images
     *
     * @param \Duedinoi\AdminBundle\Entity\Image $galleryImages
     */
    public function removeGalleryImage(\Duedinoi\AdminBundle\Entity\Image $galleryImages)
    {
        $this->gallery_images->removeElement($galleryImages);
    }

    /**
     * Get gallery_images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGalleryImages()
    {
        return $this->gallery_images;
    }
    
    public function __toString() {
        return $this->name;
    }
    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $updated_at;


    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Gallery
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     * @return Gallery
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Get updated_at
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
}
