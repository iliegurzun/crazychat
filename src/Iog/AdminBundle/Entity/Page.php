<?php

namespace Iog\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Page
 */
class Page
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $seoTitle;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $description;

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
    private $blocks;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->blocks = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return Page
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set seoTitle
     *
     * @param string $seoTitle
     * @return Page
     */
    public function setSeoTitle($seoTitle)
    {
        $this->seoTitle = $seoTitle;

        return $this;
    }

    /**
     * Get seoTitle
     *
     * @return string 
     */
    public function getSeoTitle()
    {
        return $this->seoTitle;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Page
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Page
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
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Page
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
     * @return Page
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

    /**
     * Add blocks
     *
     * @param \Iog\AdminBundle\Entity\Block $blocks
     * @return Page
     */
    public function addBlock(\Iog\AdminBundle\Entity\Block $blocks)
    {
        $this->blocks[] = $blocks;

        return $this;
    }

    /**
     * Remove blocks
     *
     * @param \Iog\AdminBundle\Entity\Block $blocks
     */
    public function removeBlock(\Iog\AdminBundle\Entity\Block $blocks)
    {
        $this->blocks->removeElement($blocks);
    }

    /**
     * Get blocks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBlocks()
    {
        return $this->blocks;
    }
    /**
     * @var string
     */
    private $seo_description;

    /**
     * @var string
     */
    private $seo_keywords;


    /**
     * Set seo_description
     *
     * @param string $seoDescription
     * @return Page
     */
    public function setSeoDescription($seoDescription)
    {
        $this->seo_description = $seoDescription;

        return $this;
    }

    /**
     * Get seo_description
     *
     * @return string 
     */
    public function getSeoDescription()
    {
        return $this->seo_description;
    }

    /**
     * Set seo_keywords
     *
     * @param string $seoKeywords
     * @return Page
     */
    public function setSeoKeywords($seoKeywords)
    {
        $this->seo_keywords = $seoKeywords;

        return $this;
    }

    /**
     * Get seo_keywords
     *
     * @return string 
     */
    public function getSeoKeywords()
    {
        return $this->seo_keywords;
    }
    
    public function __toString() {
        if($this->title) {
            return $this->title;
        }
        return '';
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $menu_items;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $children;

    /**
     * @var \Iog\AdminBundle\Entity\Page
     */
    private $parent;


    /**
     * Add menu_items
     *
     * @param \Iog\AdminBundle\Entity\MenuItem $menuItems
     * @return Page
     */
    public function addMenuItem(\Iog\AdminBundle\Entity\MenuItem $menuItems)
    {
        $this->menu_items[] = $menuItems;

        return $this;
    }

    /**
     * Remove menu_items
     *
     * @param \Iog\AdminBundle\Entity\MenuItem $menuItems
     */
    public function removeMenuItem(\Iog\AdminBundle\Entity\MenuItem $menuItems)
    {
        $this->menu_items->removeElement($menuItems);
    }

    /**
     * Get menu_items
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMenuItems()
    {
        return $this->menu_items;
    }

    /**
     * Add children
     *
     * @param \Iog\AdminBundle\Entity\Page $children
     * @return Page
     */
    public function addChild(\Iog\AdminBundle\Entity\Page $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \Iog\AdminBundle\Entity\Page $children
     */
    public function removeChild(\Iog\AdminBundle\Entity\Page $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param \Iog\AdminBundle\Entity\Page $parent
     * @return Page
     */
    public function setParent(\Iog\AdminBundle\Entity\Page $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Iog\AdminBundle\Entity\Page 
     */
    public function getParent()
    {
        return $this->parent;
    }
}
