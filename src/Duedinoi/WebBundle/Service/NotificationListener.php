<?php
namespace Duedinoi\WebBundle\Service;

use Duedinoi\UserBundle\Entity\User;
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
    
    protected $session;
    
    protected $router;
    
    public function __construct($em, $context, $session, $router)
    {
        $this->securityContext = $context;
        $this->em = $em;
        $this->user = $context->getToken()->getUser();
        $this->session = $session;
        $this->router = $router;
    }
    
    public function logNotification(ProfileEvent $event, $eventName)
    {
        if(!$this->getUser() instanceof User) {
            $this->session->set('referal_url', $this->router->generate('duedinoi_user_profile', array(
                'userslug' => $event->getUser()->getSlug()
            ), true));
            
            return;
        }

        if ($this->getUser() == $event->getUser()) {
            return;
        }
        $notification = new Notification();
        $notification
            ->setFromUser($this->getUser())
            ->setToUser($event->getUser())
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
