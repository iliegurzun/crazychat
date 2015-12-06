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
    protected $minAge;
    
    protected $maxAge;
    
    protected $online = array();
    
    protected $withPhoto = array();
    
    protected $username;
    
    function getMinAge() {
        return $this->minAge;
    }

    function getMaxAge() {
        return $this->maxAge;
    }

    function getOnline() {
        return $this->online;
    }

    function getWithPhoto() {
        return $this->withPhoto;
    }

    function getUsername() {
        return $this->username;
    }

    function setMinAge($minAge) {
        $this->minAge = $minAge;
        return $this;
    }

    function setMaxAge($maxAge) {
        $this->maxAge = $maxAge;
        return $this;
    }

    function setOnline($online) {
        $this->online = $online;
        return $this;
    }

    function setWithPhoto($withPhoto) {
        $this->withPhoto = $withPhoto;
        return $this;
    }

    function setUsername($username) {
        $this->username = $username;
        return $this;
    }
}
