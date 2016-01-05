<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Duedinoi\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Duedinoi\WebBundle\Form\RegisterType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Description of RegistrationController
 *
 * @author Ilie
 */
class RegistrationController extends Controller
{
    
    public function registerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if (!$page = $this->get('duedinoi.web.page')->getCurrentPage()) {
            $page = null;
        }
        $form = $this->createForm(new RegisterType($this->container->get('translator')));
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user = $userManager->createUser();
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);
            $ipAddress = $request->getClientIp();
            $user->setIpAddress($ipAddress);
            $userManager->updateUser($user);
//            $this->get('duedinoi.chat_register')->registerUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('duedinoi_edit_profile');
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->render('DuedinoiWebBundle:Default:register.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
