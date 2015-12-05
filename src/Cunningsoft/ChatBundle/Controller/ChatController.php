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
        $messages = $this->getDoctrine()->getRepository('CunningsoftChatBundle:Message')->findBy(
            array(
                'channel' => $channel
            ),
            array('id' => 'desc')
        );
        $messages = array_reverse($messages);

        return array(
            'messages' => $messages,
        );
    }
}
