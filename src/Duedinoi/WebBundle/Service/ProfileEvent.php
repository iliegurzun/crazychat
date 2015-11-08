<?php
namespace Duedinoi\WebBundle\Service;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Symfony\Component\EventDispatcher\Event;
/**
 * Description of ProfileEvent
 *
 * @author Ilie
 */
class ProfileEvent extends Event
{
    protected $user;
    
    public function __construct($user)
    {
        $this->user = $user;
    }
    
    /**
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
