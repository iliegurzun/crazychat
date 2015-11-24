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
use Duedinoi\WebBundle\Form\ContactType;
use Duedinoi\AdminBundle\Entity\ContactMessage;
use Duedinoi\AdminBundle\Form\ImageType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Duedinoi\AdminBundle\Entity\Image;
use Duedinoi\WebBundle\Service\ProfileEvents;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        if (!$page = $this->get('duedinoi.web.page')->getCurrentPage()) {
            throw $this->createNotFoundException('Not found');
        }

        return $this->render('DuedinoiWebBundle:Default:index.html.twig', array(
            'page' => $page,
        ));
    }

    public function homepageAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if (!$page = $this->get('duedinoi.web.page')->getCurrentPage()) {
            $page = null;
        }
        $form = $this->createForm(new RegisterType($this->container->get('translator')));
        $users = $em->getRepository('DuedinoiUserBundle:User')->getLastRegistered();
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
            'users' => $users
        ));
    }

    public function editProfileAction(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(
            new EditProfileType($this->container->get('translator')),
            $user
        );
        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $this->get('session')->getFlashBag()->add(
                    'success',
                    $this->get('translator')->trans('profile.updated')
                );

                return $this->redirect($this->generateUrl('duedinoi_edit_profile'));
            }
        }

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

    public function photosAction(Request $request)
    {
        $user = $this->getUser();
        $image = new \Duedinoi\AdminBundle\Entity\Image();
        $image->setUser($user);
        $form = $this->createForm(new ImageType(), $image);
        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($image);
                $em->flush();
                $this->get('session')->getFlashBag()->add(
                    'success',
                    $this->get('translator')->trans('photo.uploaded')
                );
                
                return $this->redirect($this->generateUrl('duedinoi_photos'));
            }
        }
        
        return $this->render('DuedinoiWebBundle:Default:photos.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }

    public function dashboardAction(Request $request)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $userRepo = $em->getRepository('DuedinoiUserBundle:User');
        $activeUsers = $userRepo->findActiveExcept($user);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $activeUsers,
            $this->get('request')->query->get('page', 1)/*page number*/,
            20/*limit per page*/
        );

        return $this->render('DuedinoiWebBundle:Default:dashboard.html.twig', array(
            'activeUsers' => $pagination
        ));
    }

    public function myProfileAction(Request $request)
    {

        return $this->render('DuedinoiWebBundle:Default:profile.html.twig', array(
            'user' => $this->getUser()
        ));
    }

    public function userProfileAction($userslug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('DuedinoiUserBundle:User')->findOneBySlug($userslug);
        if (!$user instanceof \Duedinoi\UserBundle\Entity\User) {
            throw $this->createNotFoundException();
        }
        $dispatcher = $this->get('event_dispatcher');
        $event = new \Duedinoi\WebBundle\Service\ProfileEvent($user);
        $dispatcher->dispatch(ProfileEvents::EVENT_VIEW_PROFILE, $event);
        $comment = new \Duedinoi\WebBundle\Entity\Comment();
        $comment->setAuthor($this->getUser())
            ->setUser($user);
        $form = $this->createForm(new \Duedinoi\WebBundle\Form\CommentType(), $comment);
        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em->persist($comment);
                $em->flush();
                $this->get('session')->getFlashBag()->add(
                    'success',
                    $this->get('translator')->trans('comment.posted')
                );

                return $this->redirect($this->generateUrl('duedinoi_user_profile', array(
                    'userslug' => $user->getSlug()
                )));

            }
        }

        return $this->render('DuedinoiWebBundle:Default:profile.html.twig', array(
            'user' => $user,
            'form' => $form->createView()
        ));
    }

    public function chatServerAction($userslug, Request $request)
    {

        set_time_limit(0);
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('DuedinoiUserBundle:User')->findOneBySlug($userslug);
        if (!$user) {
            throw $this->createNotFoundException('User not found!');
        }
        while (true) {
            clearstatcache();
            break;
        }
    }

    public function userConversationAction($userslug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('DuedinoiUserBundle:User')->findOneBySlug($userslug);
        if (!$user) {
            throw $this->createNotFoundException('User not found!');
        }

        return $this->render('DuedinoiWebBundle:Default:user_conversation.html.twig', array(//            ''
        ));
    }

    public function contactAction(Request $request)
    {
        $message = new ContactMessage();
        $form = $this->createForm(new ContactType($this->container->get('translator')), $message);
        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($message);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add(
                    'success',
                    $this->get('translator')->trans('contact.message_sent')
                );
                
                return $this->redirect($this->generateUrl('duedinoi_contact'));
            }
        }
        
        return $this->render('DuedinoiWebBundle:Default:contact.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    public function profilePictureAction($id, Request $request)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $imageRepo = $em->getRepository("DuedinoiAdminBundle:Image");
        $image = $imageRepo->find($id);
        if (!$image instanceof Image) {
            throw $this->createNotFoundException();
        }
        if (!$image->belongsTo($user)) {
            throw $this->createAccessDeniedException();
        }
        foreach ($user->getPhotos() as $photo) {
            $photo->setIsProfilePicture(false);
            $em->persist($photo);
        }
        $image->setIsProfilePicture(true);
        $em->persist($image);
        $em->flush();
        
        return new JsonResponse(array(
            'success' => true
        ));
    }
    
    public function messagesAction()
    {
        /* @var $provider \FOS\MessageBundle\Provider\Provider */
        $provider = $this->get('fos_message.provider');
        $inboxThreads = $provider->getInboxThreads();
        $sentboxThreads = $provider->getSentThreads();
        $threads = array_merge($inboxThreads, $sentboxThreads);
        
        return $this->render('DuedinoiWebBundle:Default:messages.html.twig', array(
            'threads' => $threads
        ));
    }
    
    public function threadAction($userslug, Request $request)
    {
        $currentUser = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('DuedinoiUserBundle:User')->findOneBySlug($userslug);
        if(!$user instanceof \Duedinoi\UserBundle\Entity\User) {
            throw $this->createNotFoundException();
        }
        $form = $this->get('fos_message.new_thread_form.factory')->create();
        $form
            ->remove('recipient')
            ->remove('subject');
//        $thread = $em->getRepository('DuedinoiWebBundle:Thread')
        
        $composer = $this->get('fos_message.composer');

        $message = $composer->newThread()
            ->setSender($currentUser)
            ->addRecipient($user)
            ->setBody($form->getData()->getBody())
            ->getMessage();
        
        return $this->render('DuedinoiWebBundle:Default:thread.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }
    
    public function loadMessagesAction($userslug, Request $request)
    {
        
        while ( true )
        {
            $requestedTimestamp = (int)$request->get('timestamp', null);
            clearstatcache();
            $session = $this->get('session');
            $modifiedAt = $session->get('conversation', time());
            if ($requestedTimestamp == null || $modifiedAt > $requestedTimestamp)
            {
                set_time_limit(0);
                $em = $this->getDoctrine()->getManager();
                $user = $em->getRepository('DuedinoiUserBundle:User')->findOneBySlug($userslug);
                $modifiedAt = time();
                $session->set('conversation', time());
                /* @var $provider \FOS\MessageBundle\Provider\Provider */
                $provider = $this->get('fos_message.provider');
                $currentThread = null;
                $sentboxThreads = $provider->getSentThreads();
                foreach($sentboxThreads as $thread) {
                    
                    var_dump(get_class($thread));
                    var_dump(get_class_methods($thread));die;
                }
                $inboxThreads = $provider->getInboxThreads();
                
                $threads = array_merge($inboxThreads, $sentboxThreads);
                
                
                return new JsonResponse(array(
                    'success'   => true,
                    'content'   => $this->renderView('DuedinoiWebBundle:Component:_messages.html.twig', array(
                       'messages' => array()
                    )),
                    'timestamp' => $modifiedAt
                ));
                break;
            }
            else
            {
                sleep(1);
                continue;
            }
        }
    }
    
    public function notificationsAction(Request $request)
    {
        $notifications = $this->get('notification_manager')->getNotifications();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $notifications,
            $this->get('request')->query->get('page', 1)/*page number*/,
            10/*limit per page*/
        );
        
        return $this->render('DuedinoiWebBundle:Default:notifications.html.twig', array(
            'notifications' => $pagination
        ));
    }
    
    public function aboutAction()
    {
        return $this->render('DuedinoiWebBundle:Default:about.html.twig', array(
        ));
    }
}
