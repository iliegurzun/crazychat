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
use Symfony\Component\Form\Extension\Core\Type\NumberType;

/**
 * Description of SearchFormType
 *
 * @author Ilie
 */
class SearchFormType extends AbstractType
{
    protected $translator;
    
    public function __construct($translator) 
    {
        $this->translator = $translator;
    }
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder
            ->add('minAge', NumberType::class, array(
                'label' => ' ',
                'required' => false
            ))
            ->add('maxAge', 'number', array(
                'label' => ' ',
                'required' => false
            ))
            ->add('withPhoto', 'choice', array(
                'label' => ' ',
                'required' => false,
                'choices' => array(
                    'withPhoto' => $this->translator->trans('search.with_photo')
                ),
                'expanded' => true,
                'multiple' => true
            ))
            ->add('online', 'choice', array(
                'label' => ' ',
                'required' => false,
                'choices' => array(
                    'online' => $this->translator->trans('search.online')
                ),
                'expanded' => true,
                'multiple' => true
            ))
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
