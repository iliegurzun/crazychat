<?php

namespace Duedinoi\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Duedinoi\AdminBundle\Entity\ContactMessage;
use Duedinoi\AdminBundle\Form\ContactMessageType;

/**
 * MassMessage controller.
 *
 */
class MassMessageController extends Controller
{

    /**
     * Lists all ContactMessage entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CunningsoftChatBundle:Message')->findBotMessage($this->getUser());
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities,
            $this->get('request')->query->get('page', 1)/*page number*/,
            5/*limit per page*/
        );

        return $this->render('DuedinoiAdminBundle:MassMessage:index.html.twig', array(
            'entities' => $pagination,
        ));
    }
    
    public function newAction()
    {
        $em = $this->getDoctrine()->getManager();
        $userRepo = $em->getRepository('DuedinoiUserBundle:User');
        $users = $userRepo->getLastRegistered(null);
        $message = new \Cunningsoft\ChatBundle\Entity\Message();
        $form = $this->createForm(new \Duedinoi\AdminBundle\Form\MassMessageType($users), $message);
        
        return $this->render('DuedinoiAdminBundle:MassMessage:new.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userRepo = $em->getRepository('DuedinoiUserBundle:User');
        $users = $userRepo->getLastRegistered(null);
        $message = new \Cunningsoft\ChatBundle\Entity\Message();
        $form = $this->createForm(new \Duedinoi\AdminBundle\Form\MassMessageType($users), $message);
        if ($request->isMethod('post')) {
            $form->handleRequest($request);
            foreach ($message->getReceivers() as $receiver) {
                $newMessage = new \Cunningsoft\ChatBundle\Entity\Message();
                $newMessage
                    ->setAuthor($this->getUser())
                    ->setIsMass(true)
                    ->setInsertDate(new \DateTime())
                    ->setMessage($message->getMessage())
                    ->setChannel($receiver->getSlug())
                    ->setReceiver($receiver);
                $em->persist($newMessage);
            }
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'notice', 'The mass message has been sent!'
            );
            
            return $this->redirect($this->generateUrl('massmessage'));
        }
    }
}
