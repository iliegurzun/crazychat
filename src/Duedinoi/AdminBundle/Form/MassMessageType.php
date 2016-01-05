<?php

namespace Duedinoi\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MassMessageType extends AbstractType
{
    protected $users;
    
    public function __construct($users) {
        $this->users = $users;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('receivers', 'entity', array(
                'class'   => 'DuedinoiUserBundle:User',
                'expanded' => false,
                'multiple' => true,
                'choices' => $this->users,
                'label_attr' => array(
                    'class' => 'col-lg-4 control-label'
                ),
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('message', 'textarea', array(
                'label_attr' => array(
                    'class' => 'col-lg-4 control-label'
                ),
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Message'
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
            'data_class' => 'Cunningsoft\ChatBundle\Entity\Message'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'duedinoi_adminbundle_massmessage';
    }
}
