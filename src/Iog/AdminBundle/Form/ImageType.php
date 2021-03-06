<?php

namespace Iog\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImageType extends AbstractType
{

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('file', 'file', array(
          'label' => 'Browse',
          'label_attr' => array(
              'class' => 'btn btn-primary btn-file'
          ),
      ));
//      ->add('preview', new PreviewType(), array(
//          'property_path' => 'web_path'
//      ));
    
    if ($options['can_be_removed']) {
      $builder->add('to_be_removed', 'checkbox');
    }
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
        'data_class' => 'Iog\AdminBundle\Entity\Image',
        'can_be_removed' => false
    ));
  }

  public function getName()
  {
    return 'iog_admin_imagetype';
  }

}
