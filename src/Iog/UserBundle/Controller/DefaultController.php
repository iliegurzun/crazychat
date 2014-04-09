<?php

namespace Iog\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('IogUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
