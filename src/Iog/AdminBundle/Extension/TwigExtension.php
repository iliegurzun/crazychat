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
      $dm = $this->service_container->getDoctrine()->getManager();
      
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
    
    public function getAdminMenuSortable($menu, $id = null)
    {
        $this->document = new \DOMDocument;
        $this->items = $menu->getItems();
        
        $list = $this->generateAdminMenuHtml($menu->getDirectItems());
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

          $this->addItemActions($item);
          $element->appendChild($item);

          if ( $menuItem->getChildren() ){
              $element->appendChild($this->generateAdminMenuHtml($menuItem->getChildren()));
          }

          $list->appendChild($element);
        }
            
        return $list;
    }
    
    private function addItemActions(\DOMNode $node){         
        $remove = $this->document->createElement('i');
        $remove->setAttribute('class', 'icon-remove menu-controls hide');

        $edit = $this->document->createElement('i');
        $edit->setAttribute('class', 'icon-edit menu-controls hide');
        
        $node->appendChild($remove);
        $node->appendChild($edit);
    }
}