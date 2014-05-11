<?php

namespace Iog\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class UploadifyType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('Filedata', 'file', array(
//                    'label' => '',
                    'property_path' => 'file'
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Iog\AdminBundle\Entity\Image',
//            'validation_groups' => array('Default', 'document_mandatory'),
            'csrf_protection' => false,
        ));
    }

    public function getName()
    {
        return '';
    }

}
