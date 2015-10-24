<?php

namespace Duedinoi\WebBundle\Controller;

use Duedinoi\WebBundle\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Duedinoi\WebBundle\Form\EditProfileType;
use Duedinoi\WebBundle\Form\SettingsType;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        if ( !$page = $this->get('duedinoi.web.page')->getCurrentPage()) {
            throw $this->createNotFoundException('Not found');
        }
        
        return $this->render('DuedinoiWebBundle:Default:index.html.twig', array(
            'page' => $page,
        ));
    }
    
    public function homepageAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if(!$page = $this->get('duedinoi.web.page')->getCurrentPage()) {
            $page = null;
        }
        $form = $this->createForm(new RegisterType($this->container->get('translator')));
        $users = $em->getRepository('DuedinoiUserBundle:User')->getLastRegistered();
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
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

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('duedinoi_edit_profile');
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->render('DuedinoiWebBundle:Default:homepage.html.twig', array(
            'page' => $page,
            'form' => $form->createView(),
            'users'=> $users
        ));
    }
    
    public function editProfileAction(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(
            new EditProfileType($this->container->get('translator')), 
            $user
        );
        
        return $this->render('DuedinoiWebBundle:Default:edit_profile.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }
    
    public function settingsAction(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(new SettingsType($this->container->get('translator')), $user);
        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $this->get('session')->getFlashBag()->add(
                    'success',
                    $this->get('translator')->trans('settings.updated')
                );
                
                return $this->redirect($this->generateUrl('duedinoi_settings'));
            }
        }
        
        return $this->render('DuedinoiWebBundle:Default:settings.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
