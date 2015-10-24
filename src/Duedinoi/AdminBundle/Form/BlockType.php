<?php

namespace Duedinoi\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BlockType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('language', 'choice', array(
                    'label' => 'Language',
                    'label_attr' => array(
                        'class' => 'col-lg-4 control-label'
                    ),
                    'attr' => array(
                        'class' => 'form-control',
                    ),
                    'choices'=> array(
                        'en' => 'English',
                        'it' => 'Italian'
                    )
                ))
            ->add('content', 'textarea', array(
                    'label' => 'Content',
                    'label_attr' => array(
                        'class' => 'col-lg-4 control-label'
                    ),
                    'attr' => array(
                        'class' => 'form-control note-editor tinymce',
//                        'placeholder' => 'Menu name'
                    )
                ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Duedinoi\AdminBundle\Entity\Block', 
            'csrf_protection' => false,
            'allow_extra_fields' => true,
            'ignore_extra_data' => true,
            'cascade_validation' => true,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'duedinoi_adminbundle_block';
    }
}
