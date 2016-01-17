<?php

namespace Cunningsoft\ChatBundle\Controller;

use Cunningsoft\ChatBundle\Entity\Message;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/chat")
 */
class ChatController extends Controller
{
    /**
     * @return Response
     *
     * @Route("/show/{channel}", name="cunningsoft_chat_show", defaults={"channel" = "default"})
     * @Template
     */
    public function showAction($channel)
    {
        return array(
            'updateInterval' => $this->container->getParameter('cunningsoft_chat.update_interval'),
            'channel' => $channel
        );
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     *
     * @Route("/post/{channel}", name="cunningsoft_chat_post", defaults={"channel" = "default"})
     */
    public function postAction(Request $request, $channel)
    {
        $em = $this->getDoctrine()->getManager();
        $receiver = $em->getRepository('DuedinoiUserBundle:User')->findOneBySlug($channel);
        if(!$receiver instanceof \Cunningsoft\ChatBundle\Entity\AuthorInterface) {
            throw $this->createNotFoundException();
        }
        $message = new Message();
        $message->setAuthor($this->getUser());
        $message->setChannel($channel);
        $message->setReceiver($receiver);
        $message->setMessage($request->get('message'));
        $message->setInsertDate(new \DateTime());
        $em->persist($message);
        $em->flush();

        return new Response('Successful');
    }

    /**
     * @Route("/list/{channel}", name="cunningsoft_chat_list", defaults={"channel" = "default"})
     * @Template
     */
    public function listAction($channel)
    {
        $currentUser = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $receiver = $em->getRepository('DuedinoiUserBundle:User')->findOneBySlug($channel);
        if(!$receiver instanceof \Cunningsoft\ChatBundle\Entity\AuthorInterface) {
            throw $this->createNotFoundException();
        }
        $messages = $this->get('chat_thread_service')->getThreadMessages($receiver);
        if (!empty($messages)) {
            foreach ($messages as $key => $message) {
                if ($message->getRemovedFrom() == $currentUser) {
                    unset($messages[$key]);
                } else {
                    if ($message->getAuthor() != $currentUser) {
                        if (!$message->getIsRead()) {
                            $message->setIsRead(true);
                            $em->persist($message);
                        }
                    }
                }

                $em->flush();
            }
        }

        return array(
            'messages' => $messages,
        );
    }
    
    /**
     * @Route("/remove/{id}", name="cunningsoft_message_remove")
     * @Template
     */
    public function removeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $messageRepo = $em->getRepository('CunningsoftChatBundle:Message');
        $message = $messageRepo->find($id);
        if (!$message) {
            throw $this->createNotFoundException();
        }
        $em->remove($message);
        $em->flush();
        
        return new Response('Successful');
    }

    /**
     * @Route("/remove-thread/{channel}", name="cunningsoft_chat_thread_remove")
     * @Template
     */
    public function removeThreadAction($channel)
    {
        $currentUser = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $receiver = $em->getRepository('DuedinoiUserBundle:User')->findOneBySlug($channel);
        if(!$receiver instanceof \Cunningsoft\ChatBundle\Entity\AuthorInterface) {
            throw $this->createNotFoundException();
        }
        $messages = $this->get('chat_thread_service')->getThreadMessages($receiver);
        if (!empty($messages)) {
            /** @var Message $message */
            foreach ($messages as $message) {
                if (empty($message->getRemovedFrom())) {
                    $message->setRemovedFrom($currentUser);
                } else {
                    $em->remove($message);
                }
            }
            $em->flush();
        }

        $this->get('session')->getFlashBag()->add(
            'success',
            $this->get('translator')->trans('thread.removed')
        );

        return $this->redirect($this->generateUrl('duedinoi_messages'));
    }
}
