<?php

namespace Iog\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MenuItem
 */
class MenuItem
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
    private $position = 0;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $updated_at;


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
     * @return MenuItem
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
     * Set position
     *
     * @param string $position
     * @return MenuItem
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return MenuItem
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
     * @return MenuItem
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
     * @var \Iog\AdminBundle\Entity\Menu
     */
    private $menu;


    /**
     * Set menu
     *
     * @param \Iog\AdminBundle\Entity\Menu $menu
     * @return MenuItem
     */
    public function setMenu(\Iog\AdminBundle\Entity\Menu $menu = null)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu
     *
     * @return \Iog\AdminBundle\Entity\Menu 
     */
    public function getMenu()
    {
        return $this->menu;
    }
    /**
     * @var \Iog\AdminBundle\Entity\MenuItem
     */
    private $parent;


    /**
     * Set parent
     *
     * @param \Iog\AdminBundle\Entity\MenuItem $parent
     * @return MenuItem
     */
    public function setParent(\Iog\AdminBundle\Entity\MenuItem $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Iog\AdminBundle\Entity\MenuItem 
     */
    public function getParent()
    {
        return $this->parent;
    }
    
    public function __toString() {
        return $this->title;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $children;

    /**
     * @var \Iog\AdminBundle\Entity\Page
     */
    private $page;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add children
     *
     * @param \Iog\AdminBundle\Entity\MenuItem $children
     * @return MenuItem
     */
    public function addChild(\Iog\AdminBundle\Entity\MenuItem $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \Iog\AdminBundle\Entity\MenuItem $children
     */
    public function removeChild(\Iog\AdminBundle\Entity\MenuItem $children)
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
     * Set page
     *
     * @param \Iog\AdminBundle\Entity\Page $page
     * @return MenuItem
     */
    public function setPage(\Iog\AdminBundle\Entity\Page $page = null)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return \Iog\AdminBundle\Entity\Page 
     */
    public function getPage()
    {
        return $this->page;
    }
    /**
     * @var string
     */
    private $link;


    /**
     * Set link
     *
     * @param string $link
     * @return MenuItem
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
    }
}
