<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Duedinoi\UserBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use FOS\UserBundle\Event\GetResponseUserEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RegistrationConfirmListener implements EventSubscriberInterface
{
    private $router;
    
    protected $session;
    
    protected $securityContext;
    
    protected $em;

    public function __construct(UrlGeneratorInterface $router, $session, $securityContext, $em)
    {
        $this->router = $router;
        $this->session = $session;
        $this->securityContext = $securityContext;
        $this->em = $em;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
                FOSUserEvents::REGISTRATION_CONFIRM => 'onRegistrationConfirm'
        );
    }

    public function onRegistrationConfirm(GetResponseUserEvent $event)
    {
        if ($event->getUser() instanceof \Duedinoi\UserBundle\Entity\User) {
            $url = $this->session->get('referal_url');
            if ($url) {
                $event->getUser()->setReferral($url);
                $this->em->persist($event->getUser());
                $this->em->flush();
                $this->session->remove('referal_url');
            }
        }
        $url = $this->router->generate('duedinoi_dashboard');

        $event->setResponse(new RedirectResponse($url));
    }
}