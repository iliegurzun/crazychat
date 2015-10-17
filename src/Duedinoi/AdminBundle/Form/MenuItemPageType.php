<?php

namespace Duedinoi\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MenuItemPageType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('page',null, array(
                'label' => 'Select a page',
                'label_attr' => array(
                    'class' => 'col-lg-4 control-label'
                ),
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('link', 'text', array(
                'label' => 'Add external link',
                'label_attr' => array(
                    'class' => 'col-lg-4 control-label'
                ),
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'eg: http://...'
                )
            ));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Duedinoi\AdminBundle\Entity\MenuItem',
            'csrf_protection' => false
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return '';
    }
}
