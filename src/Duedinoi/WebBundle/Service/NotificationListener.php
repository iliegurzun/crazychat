<?php
namespace Duedinoi\WebBundle\Service;

use Duedinoi\WebBundle\Service\ProfileEvent;
use Duedinoi\WebBundle\Entity\Notification;

/**
 * Description of NotificationListener
 *
 * @author Ilie
 */
class NotificationListener 
{
    protected $em;
    
    protected $securityContext;
    
    protected $user;
    
    public function __construct($em, $context)
    {
        $this->em = $em;
        $this->user = $context->getToken()->getUser();
    }
    
    public function logNotification(ProfileEvent $event, $eventName)
    {
        if ($this->getUser() == $event->getUser()) {
            return;
        }
        $notification = new Notification();
        $notification
            ->setFromUser($event->getUser())
            ->setToUser($this->getUser())
            ->setType($eventName)
        ;
        $this->em->persist($notification);
        $this->em->flush($notification);
    }
            
    /**
     * @return \Duedinoi\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
