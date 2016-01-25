<?php
/**
 * Created by PhpStorm.
 * User: Ilie
 * Date: 25/1/2016
 * Time: 10:16 PM
 */

namespace Duedinoi\WebBundle\Service;

use Duedinoi\AdminBundle\Entity\RecruitedMember;
use FOS\UserBundle\Event\FormEvent;
use Duedinoi\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class RegistrationListener
{
    protected $em;

    protected $security_context;

    protected $router;

    public function __construct($em, $security_context, Router $router)
    {
        $this->em = $em;
        $this->security_context = $security_context;
        $this->router = $router;
    }

    public function onRegister(FormEvent  $event)
    {
        /** @var User $user */
        $user = $event->getForm()->getData();
        $recruitedMember = $this->getRecruitedMember($user->getEmail());
        if ($recruitedMember instanceof RecruitedMember) {
            $user
                ->setRecruiter($recruitedMember->getRecruiter())
                ->setConverter($recruitedMember->getConverter());

            $this->em->persist($user);
            $this->em->flush();

            return $event;
        }
    }

    protected function getRecruitedMember($email)
    {
        $memberRepo = $this->em->getRepository('DuedinoiAdminBundle:RecruitedMember');
        $member = $memberRepo->findOneBy(array('email' => $email));

        return $member;
    }
}