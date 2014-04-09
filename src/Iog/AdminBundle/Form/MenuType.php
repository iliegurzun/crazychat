<?php

namespace Iog\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MenuType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Iog\AdminBundle\Entity\Menu', 
            'csrf_protection' => false,
            'allow_extra_fields' => true,
            'ignore_extra_data' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'iog_adminbundle_menu';
    }
}
