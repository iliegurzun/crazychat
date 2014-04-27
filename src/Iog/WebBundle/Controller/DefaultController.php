<?php

namespace Iog\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        if ( !$page = $this->get('iog.web.page')->getCurrentPage()) {
            throw $this->createNotFoundException('Not found');
        }
        
        return $this->render('IogWebBundle:Default:index.html.twig', array(
            'page' => $page,
        ));
    }
}
