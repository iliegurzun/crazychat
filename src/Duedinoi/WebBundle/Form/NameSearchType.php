<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Duedinoi\WebBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of NameSearchType
 *
 * @author Ilie
 */
class NameSearchType extends AbstractType
{
    protected $translator;
    
    public function __construct($translator) 
    {
        $this->translator = $translator;
    }
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder
            ->add('username')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) 
    {
        $resolver->setDefaults(array(
            'data_class'        => 'Duedinoi\WebBundle\Entity\SearchMapping',
            'csrf_protection'   => false,
            'allow_extra_fields'=> true
        ));
    }
    
    public function getName()
    {
        return 'search_users';
    }
}
