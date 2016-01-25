<?php
/**
 * Created by PhpStorm.
 * User: Ilie
 * Date: 25/1/2016
 * Time: 10:06 PM
 */

namespace Duedinoi\UserBundle\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        // Tells the dispatcher that you want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return array(FormEvents::POST_SET_DATA => 'postSetData');
    }

    public function postSetData(FormEvent $event)
    {
        $user = $event->getData();
        $form = $event->getForm();
        dump($user->getRole());die;
        if($user->getRole()) {
            die('aici');
        }
        //die;

        if (!$user || null === $user->getId()) {

        }

    }
}
