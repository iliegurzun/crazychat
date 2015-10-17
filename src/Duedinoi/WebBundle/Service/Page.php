<?php

namespace Duedinoi\WebBundle\Service;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Page
 *
 * @author Ilie
 */
class Page {
    
    private $currentPage = false;
    
    public function __construct($container){
        $this->container = $container;
    }
    
    public function getCurrentPage(){
        if($this->currentPage === false) {
          $em = $this->container->get('doctrine')->getEntityManager();
          $repo = $em->getRepository('DuedinoiAdminBundle:Page');
          $path = $this->container->get('request')->getPathInfo();
          $routeName = $this->container->get('router')->match($path);
          $routeName = $routeName['_route'];
          if ($routeName != 'duedinoi_web_default') {
            $path = $this->container->get('router')->getRouteCollection()->get($routeName)->getPattern();
          }
          $this->currentPage = $repo->findOneByPath($path);
        }
        
        return $this->currentPage;
    }
}