<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Duedinoi\WebBundle\Entity;

/**
 * Description of SearchMapping
 *
 * @author Ilie
 */
class SearchMapping 
{
    
    protected $online = array();
    
    protected $withPhoto = array();
    
    protected $username;
    
    protected $sex;
            
    function getOnline() 
    {
        return $this->online;
    }

    function getWithPhoto() 
    {
        return $this->withPhoto;
    }

    function getUsername() 
    {
        return $this->username;
    }

    function setOnline($online) 
    {
        $this->online = $online;
        return $this;
    }

    function setWithPhoto($withPhoto) 
    {
        $this->withPhoto = $withPhoto;
    
        return $this;
    }

    function setUsername($username) 
    {
        $this->username = $username;
    
        return $this;
    }
    
    function setSex($sex) 
    {
        $this->sex = $sex;
        
        return $this;
    }
    
    function getSex() 
    {
        return $this->sex;
    }
}
