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
        );
  }
  
//  public function getDefaultSeoTitle()
//  {
//      $dm = $this->service_container->getDoctrine()->getManager();
//      
//      $setting = $dm->getRepository('IogAdminBundle:Setting')->findOneBy(array('name' => 'default_seo_title'));
//      
//      if($setting && $setting->getValue()) {
//          return $setting->getValue();
//      }
//      return 'Default SEO Title';
//      
//  }
  
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
}