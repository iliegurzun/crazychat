<?php
namespace Duedinoi\WebBundle\Service;

/**
 * Description of NotificationManager
 *
 * @author Ilie
 */
class NotificationManager 
{
    
    protected $securityContext;
    
    protected $user;
    
    protected $notificationRepository;
    
    public function __construct($securityContext, $notificationRepo) 
    {
        $this->securityContext = $securityContext;
        $this->user = $securityContext->getToken()->getUser();
        $this->notificationRepository = $notificationRepo;
    }
    
    public function getNotifications()
    {
        $notifications = $this->notificationRepository->getNotificationsForUser($this->user);
        
        return $notifications;
    }
}
