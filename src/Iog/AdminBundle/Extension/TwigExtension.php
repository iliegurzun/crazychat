<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TwigExtension
 *
 * @author Ilie
 */
namespace Iog\AdminBundle\Extension;

use \Symfony\Component\Yaml\Parser;

class TwigExtension extends \Twig_Extension
{

  private $service_container;
  
  private $document;
  
  public function __construct($service_container)
  {
    $this->service_container = $service_container;
  }

  public function getName()
  {
    return 'admin_twig_extension';
  }
  
  public function getFilters()
  {
    return array(
//        'time_diff' => new \Twig_Filter_Method($this, 'getTimeDifference'),
        'yes_no' => new \Twig_Filter_Method($this, 'yesNo'),
//        'child_age' => new \Twig_Filter_Method($this, 'getChildAge'),
    );
  }

  public function getFunctions()
  {
    return array(
        'admin_title' => new \Twig_Function_Method($this, 'getAdminTitle'),
        'get_admin_menu' => new \Twig_Function_Method($this, 'getAdminMenu'),
        'get_admin_menu_sortable' => new \Twig_Function_Method($this, 'getAdminMenuSortable'),
        'seo_title' => new \Twig_Function_Method($this, 'getDefaultSeoTitle'),
        );
  }
  
  public function getDefaultSeoTitle()
  {
      $dm = $this->service_container->get('doctrine')->getManager();
      
      $setting = $dm->getRepository('IogAdminBundle:Setting')->findOneBy(array('name' => 'default_seo_title'));
      
      if($setting && $setting->getValue()) {
          return $setting->getValue();
      }
      return '';
      
  }
  
//  public function getAdminTitle()
//  {
//      $yml = new YamlParser();
//      var_dump(get_class_methods($yml));die;
//  }
  
    public function getAdminMenu()
    {
      $yaml = new Parser();

      $config_file = __DIR__ . '/../../../../app/config/config_admin.yml';
      try {
          $config = $yaml->parse(file_get_contents($config_file));
      } catch (ParseException $e) {
          $output->writeln('Sorry, but your configuration file is not valid');
          $output->writeln($e->getMessage());
      }
      return $config['Menu'];
    }
  
    public function getAdminTitle() 
    {
        $yaml = new Parser();

        $config_file = __DIR__ . '/../../../../app/config/config_admin.yml';
        try {
            $config = $yaml->parse(file_get_contents($config_file));
        } catch (ParseException $e) {
            $output->writeln('Sorry, but your configuration file is not valid');
            $output->writeln($e->getMessage());
        }
        return $config['Project Name'];
    }
    public function yesNo($value)
    {
        if($value == false || $value == 0) {
            return 'No';
        }
        return 'Yes';
    }
    
    public function getAdminMenuSortable($menu, $id = null, $frontend = false)
    {
        
        if(is_string($menu)) {
            $em = $this->service_container->get('doctrine')->getManager();
            $menu = $em->getRepository('IogAdminBundle:Menu')->findOneByName($menu);
        }
//        $ol = '<ol id="{$menu_id}"> {$element}</ol>';
//        if($id) {
//            $ol = str_replace('{$menu_id}', $id, $ol);
//        } else {
//            $ol = str_replace('{$menu_id}', '', $ol);
//        }
//        
//        $li = '<li id="{$id}">';
//        $eli = '</li>';
//        foreach ($menuItems as $menuItem) {
//          $this->element .= $li;
//          $this->element = str_replace('{$id}', 'item-'.$menuItem->getId(), $this->element);
//
//          $this->element .= '<div>'.$menuItem->getTitle().'</div>'.$eli;
//
//          if ( $menuItem->getChildren() ){
//              $this->getAdminMenuSortable($menuItem->getChildren());
//          }
//          
//          if($this->element) {
//            $ol = str_replace('{$element}', $this->element, $ol);
//          } else {
//              $ol = str_replace('{$element}', '', $ol);
//          }
        $this->document = new \DOMDocument;
        $this->items = $menu->getItems();
        
        if($frontend == true) {
            $list = $this->generateFrontendMenuHtml($menu->getDirectItems(), true);   
        } else {
            $list = $this->generateAdminMenuHtml($menu->getDirectItems());
        }
        $list->setAttribute('id', $id);
        
        $this->document->appendChild($list);
        
        return $this->document->saveHTML();
    }
    
    private function generateAdminMenuHtml($items){
        $list = $this->document->createElement('ol');
        
        foreach ($items as $menuItem) {
          $element = $this->document->createElement('li');
          $element->setAttribute('id', 'item-' . $menuItem->getId());

          $item = $this->document->createElement('div', htmlentities($menuItem->getTitle()));
          $item->setAttribute('rel', 'tooltip');
          $item->setAttribute('title', $menuItem->getLink());
          $item->setAttribute('data-item-id', $menuItem->getId());
          

          $this->addItemActions($item);
          $element->appendChild($item);

          if ( $menuItem->getChildren() ){
              $element->appendChild($this->generateAdminMenuHtml($menuItem->getChildren()));
          }

          $list->appendChild($element);
        }
            
        return $list;
    }
    
    private function addItemActions(\DOMNode $node, $class = null){   
       
        $remove = $this->document->createElement('i');
        if($class) {
            $remove->setAttribute('class', $class);
            $node->appendChild($remove);
        } else {
            $remove->setAttribute('class', 'icon-remove menu-controls hide');

            $edit = $this->document->createElement('i');
            $edit->setAttribute('class', 'icon-edit menu-controls hide');

            $node->appendChild($remove);
            $node->appendChild($edit);
        }
    }
    
    private function generateFrontendMenuHtml($items, $first = false) {
        $list = $this->document->createElement('ol');
        
        foreach ($items as $menuItem) {
          $element = $this->document->createElement('li');
          $element->setAttribute('id', 'item-' . $menuItem->getId());

          $item = $this->document->createElement('a', htmlentities($menuItem->getTitle()));
          $item->setAttribute('href', ($menuItem->getPage() ? $menuItem->getPage()->getPath() : '#'));

          if ( count($menuItem->getChildren())){
              $this->addItemActions($element, 'icon-angle-down');
              $element->appendChild($this->generateFrontendMenuHtml($menuItem->getChildren()));
//              $element->setAttribute('class', 'has-submenu');
          }
          $element->appendChild($item);

          $list->appendChild($element);
        }
        if($first == true) {
            $searchElem = $this->document->createElement('li');
            $searchElem->setAttribute('class', 'search');
            $item = $this->document->createElement('a', ' ');
            $this->addItemActions($item, 'icon-search');
            if($menuItem->getPage()) {
                $url = $this->service_container->get('router')->generate('iog_web_default', array('path' => $menuItem->getPage()->getPath()));
                $item->setAttribute('href', $url);
            } elseif($menuItem->getLink()) {
                $item->setAttribute('href', $menuItem->getLink());
            } else {
                $item->setAttribute('href', '#');
            }
            

            $searchElem->appendChild($item);
            $list->appendChild($searchElem);
        }
        return $list;
    }
}