<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Duedinoi\WebBundle\Service;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Duedinoi\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * Description of ProfileListener
 *
 * @author Ilie
 */
class ProfileListener 
{
    protected $em;
    
    protected $security_context;
    
    protected $router;
    
    public function __construct($em, $security_context, Router $router)
    {
        $this->em = $em;
        $this->security_context = $security_context;
        $this->router = $router;
    }
    
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }
        /* @var $currentUser User */
        $currentUser = $this->security_context->getToken()->getUser();
        if ($currentUser instanceof User) {
            /* @var $request \Symfony\Component\HttpFoundation\Request */
            $request = $event->getRequest();
            if ('duedinoi_user_profile' === $request->get('_route')) {
                $userslug = $request->attributes->get('userslug');
                $user = $this->findUserBySlug($userslug);
                if ($user instanceof User) {
                    if ($currentUser->isSameUser($user)) {
                        $response = new RedirectResponse(
                            $this->router->generate('duedinoi_my_profile')
                        );
                        $event->setResponse($response);
                        
                        return $event;
                    }
                }
            }            
        }
        
        return $event;
    }
    
    /**
     * returns an user by a slug
     * 
     * @param type $userslug
     * @return type
     */
    protected function findUserBySlug($userslug)
    {
        $userRepo = $this->em->getRepository('DuedinoiUserBundle:User');
        $user = $userRepo->findOneBySlug($userslug);
        
        return $user;
    }
    
}
