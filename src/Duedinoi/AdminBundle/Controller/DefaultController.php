<?php

namespace Duedinoi\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\Yaml\Parser;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $parser = new Parser();
        $config_file = __DIR__ . '/../../../../app/config/config_admin.yml';
        $config = $parser->parse(file_get_contents($config_file));
        $items = array();
        foreach($config['Menu'] as $key => $item) {
            $items[$key] = $em->getRepository($item['class'])->findAll();
        }
        
        return $this->render('DuedinoiAdminBundle:Default:index.html.twig', array(
            'items' => $config['Menu'],
            'dashboard_items' => $items
        ));
    }
    
    public function dashboardSortAction(Request $request)
    {
        var_dump($request->request->all());die;
    }
}
