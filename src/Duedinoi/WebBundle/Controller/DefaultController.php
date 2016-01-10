<?php

namespace Duedinoi\WebBundle\Controller;

use Duedinoi\WebBundle\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Duedinoi\WebBundle\Form\EditProfileType;
use Duedinoi\WebBundle\Form\SettingsType;
use Duedinoi\WebBundle\Form\ContactType;
use Duedinoi\AdminBundle\Entity\ContactMessage;
use Duedinoi\AdminBundle\Form\ImageType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Duedinoi\AdminBundle\Entity\Image;
use Duedinoi\WebBundle\Service\ProfileEvents;
use Duedinoi\WebBundle\Form\SearchFormType;
use Duedinoi\WebBundle\Form\NameSearchType;
use Duedinoi\WebBundle\Entity\SearchMapping;
use Duedinoi\WebBundle\Service\BasicPubSub;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Duedinoi\WebBundle\Service\Chat;
use Duedinoi\WebBundle\Entity\UserLike;
use Duedinoi\WebBundle\Entity\BlockComment;

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
            $ipAddress = $request->getClientIp();
            $user->setIpAddress($ipAddress);

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
                if (!$user->hasProfilePicture()) {
                    $image->setIsProfilePicture(true);
                }
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
        $filters = $request->get('search_users');
        $filters['user'] = $user;
        $mapping = new SearchMapping();
        $searchForm = $this->createForm(new SearchFormType($this->get('translator')), $mapping);
        $userSearchForm = $this->createForm(new NameSearchType($this->get('translator')), $mapping);
        $title = $this->get('translator')->trans('title.active_users');
        
        $em = $this->getDoctrine()->getManager();
        $userRepo = $em->getRepository('DuedinoiUserBundle:User');
        if ($request->isMethod(Request::METHOD_POST)) {
            $searchForm->handleRequest($request);
            $userSearchForm->handleRequest($request);
            $title = $this->get('translator')->trans('search.search_results');
            $activeUsers = $userRepo->findByFilters($filters);
        } else {
            $activeUsers = $userRepo->findActiveExcept($user);
        }
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $activeUsers,
            $this->get('request')->query->get('page', 1)/*page number*/,
            20/*limit per page*/
        );

        return $this->render('DuedinoiWebBundle:Default:dashboard.html.twig', array(
            'activeUsers' => $pagination,
            'searchForm'  => $searchForm->createView(),
            'title'       => $title,
            'nameForm'    => $userSearchForm->createView(),
        ));
    }

    public function myProfileAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userRepo = $em->getRepository('DuedinoiUserBundle:User');
        $activeUsers = $userRepo->findActiveExcept($this->getUser(), 14);
        
        return $this->render('DuedinoiWebBundle:Default:profile.html.twig', array(
            'user'          => $this->getUser(),
            'activeUsers'   => $activeUsers
        ));
    }

    public function userProfileAction($userslug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userRepo = $em->getRepository('DuedinoiUserBundle:User');
        $user = $userRepo->findOneBySlug($userslug);
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
        $activeUsers = $userRepo->findActiveExcept($this->getUser(), 14);
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
            'user'          => $user,
            'form'          => $form->createView(),
            'activeUsers'   => $activeUsers
        ));
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
            'success' => true,
            'src'     => $image->getWebPath()
        ));
    }
    
    public function messagesAction()
    {
        $threadService = $this->get('chat_thread_service');
        $threads = $threadService->getUserThreads();
        
        return $this->render('DuedinoiWebBundle:Default:messages.html.twig', array(
            'threads' => $threads,
            'channel' => 'default'
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
        
        return $this->render('DuedinoiWebBundle:Default:single_thread.html.twig', array(
            'channel' => 'default',
            'userslug'=> $userslug
        ));
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
    
    public function likeAction($userslug, $action)
    {
        $currentUser = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('DuedinoiUserBundle:User')->findOneBySlug($userslug);
        if(!$user instanceof \Duedinoi\UserBundle\Entity\User) {
            throw $this->createNotFoundException();
        }
        
        switch ($action) {
            case 'like':
                $dispatcher = $this->get('event_dispatcher');
                $event = new \Duedinoi\WebBundle\Service\ProfileEvent($user);
                $dispatcher->dispatch(ProfileEvents::EVENT_LIKE_PROFILE, $event);
                $like = $this->getUserLike($currentUser, $user);
                $like->setStatus(UserLike::LIKE);
                $em->persist($like);
                $this->get('session')->getFlashBag()->add(
                    'success',
                    $this->get('translator')->trans('profile.like_success')
                );
                
                break;
            case 'unlike':
                $like = $this->getUserLike($currentUser, $user);
                $em->remove($like);
                $this->get('session')->getFlashBag()->add(
                    'success',
                    $this->get('translator')->trans('profile.unlike_success')
                );
                break;
            case 'block':
                $block = $this->getUserBlock($currentUser, $user);
                $em->persist($block);
                $this->get('session')->getFlashBag()->add(
                    'success',
                    $this->get('translator')->trans('profile.block_success')
                );
                break;
            case 'unblock':
                $block = $this->getUserBlock($currentUser, $user);
                $em->remove($block);
                $this->get('session')->getFlashBag()->add(
                    'success',
                    $this->get('translator')->trans('profile.unblock_success')
                );
                break;
        }
        $em->flush();
        
        return $this->redirect($this->generateUrl('duedinoi_user_profile', array(
            'userslug' => $user->getSlug()
        )));
        
    }

    public function videostreamAction($userslug)
    {
        $em = $this->getDoctrine()->getManager();
        $userRepo = $em->getRepository('DuedinoiUserBundle:User');
        $user = $userRepo->findOneBySlug($userslug);
        if (!$user instanceof \Duedinoi\UserBundle\Entity\User) {
            throw $this->createNotFoundException();
        }
        
        return $this->render('DuedinoiWebBundle:Default:videostream.html.twig', array(
            'user' => $user
        ));
    }
    
    public function answerCallAction($userslug)
    {
        $em = $this->getDoctrine()->getManager();
        $userRepo = $em->getRepository('DuedinoiUserBundle:User');
        $user = $userRepo->findOneBySlug($userslug);
        if (!$user instanceof \Duedinoi\UserBundle\Entity\User) {
            throw $this->createNotFoundException();
        }
        
        return $this->render('DuedinoiWebBundle:Default:answer_call.html.twig', array(
            'user' => $user
        ));
    }
    
    private function getUserLike($currentUser, $user)
    {
        $em = $this->getDoctrine()->getManager();
        if (!$currentUser->likesUser($user)) {
            $like = new UserLike();
            $like
                ->setFromUser($currentUser)
                ->setToUser($user);
        } else {
            $like = $em->getRepository('DuedinoiWebBundle:UserLike')->findOneBy(
                array(
                    'fromUser' => $currentUser,
                    'toUser'   => $user
                )
            );
        }
        
        return $like;
    }
    
    private function getUserBlock($currentUser, $user)
    {
        $em = $this->getDoctrine()->getManager();
        if (!$currentUser->blocksUser($user)) {
            $block = new BlockComment();
            $block
                ->setFromUser($currentUser)
                ->setToUser($user);
        } else {
            $block = $em->getRepository('DuedinoiWebBundle:BlockComment')->findOneBy(
                array(
                    'fromUser' => $currentUser,
                    'toUser'   => $user
                )
            );
        }
        
        return $block;
    }
}