<?php

namespace Iog\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\Yaml\Parser;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $parser = new Parser();
        $config_file = __DIR__ . '/../../../../app/config/config_admin.yml';
        $config = $parser->parse(file_get_contents($config_file));
        return $this->render('IogAdminBundle:Default:index.html.twig', array(
            'items' => $config['Menu']
        ));
    }
}
