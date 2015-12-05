<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Duedinoi\WebBundle\Service;

/**
 * Description of ChatThreadService
 *
 * @author Ilie
 */
class ChatThreadService 
{
    protected $em;
    
    protected $securityContext;
    
    public function __construct($em, $context)
    {
        $this->em = $em;
        $this->securityContext = $context;
    }
    
    public function getUserThreads()
    {
        $threads = array();
        $user = $this->securityContext->getToken()->getUser();
        $messageRepo = $this->em->getRepository('CunningsoftChatBundle:Message');
        $messages = $messageRepo->createQueryBuilder('t')
                ->where('t.author = :author OR t.receiver = :author')
                ->setParameter('author', $user)
                ->getQuery()->execute();
        
        foreach ($messages as $message) {
            if ($message->getAuthor() !== $user) {
                $threads[$message->getAuthor()->getUsername()] = array(
                    'user' => $message->getAuthor()
                );
            } elseif ($message->getReceiver() !== $user) {
                $threads[$message->getReceiver()->getUsername()] = array(
                    'user' => $message->getReceiver()
                );
            }
        }
        
        return $threads;
    }
    
    public function getThreadMessages($user)
    {
        $currentUser = $this->securityContext->getToken()->getUser();
        $messageRepo = $this->em->getRepository('CunningsoftChatBundle:Message');
        $messages = $messageRepo->createQueryBuilder('t')
                ->andWhere('t.author = :author OR t.receiver = :author')
                ->andWhere('t.author = :current_user OR t.receiver = :current_user')
                ->setParameter('author', $user)
                ->setParameter('current_user', $currentUser)
                ->orderBy('t.id', 'asc')
                ->getQuery()->execute();
        
        return $messages;
    }
}
