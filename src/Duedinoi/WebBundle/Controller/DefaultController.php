<?php

namespace Duedinoi\WebBundle\Controller;

use Duedinoi\WebBundle\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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

        return $this->render('DuedinoiWebBundle:Default:homepage.html.twig', array(
            'page' => $page,
            'form' => $form->createView(),
            'users'=> $users
        ));
    }
}
