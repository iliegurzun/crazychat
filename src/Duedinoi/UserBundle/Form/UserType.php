<?php

namespace Duedinoi\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Duedinoi\AdminBundle\Form\ImageType;

class UserType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('username', 'text', array(
                    'label' => 'Username',
                    'label_attr' => array(
                        'class' => 'col-lg-4 control-label'
                    ),
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => 'Username'
                    )
                ))
                ->add('email', 'email', array(
                    'label' => 'Email',
                    'label_attr' => array(
                        'class' => 'col-lg-4 control-label'
                    ),
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => 'Email'
                    )
                ))
                ->add('enabled', 'checkbox', array(
                    'label' => 'Enabled',
                    'label_attr' => array(
                        'class' => 'col-lg-4 control-label'
                    ),
                    'attr' => array(
                    )
                ))
                ->add('plainPassword', 'repeated', array(
                    'type' => 'password',
                    'required' => true,
                    'first_options' => array(
                        'label' => 'Password',
                        'label_attr' => array(
                            'class' => 'col-lg-4 control-label'
                        ),
                        'attr' => array(
                            'class' => 'form-control',
                            'placeholder' => 'Password'
                        )
                    ),
                    'second_options' => array(
                        'label' => 'Re-enter password',
                        'label_attr' => array(
                            'class' => 'col-lg-4 control-label'
                        ),
                        'attr' => array(
                            'class' => 'form-control',
                            'placeholder' => 'Re-enter password'
                        )
                    ),
                    'invalid_message' => 'Password does not match'
                ))
                ->add('role', 'choice', array(
                    'choices' => array(
                        'ROLE_USER' => 'User', 
                        'ROLE_ADMIN' => 'Admin',
                        'ROLE_ROBOT' => 'Robot'
                    ),
                    'data' => $builder->getData()->getRole(),
                    'label' => 'User Type',
                    'label_attr' => array(
                        'class' => 'col-lg-4 control-label'
                    ),
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => 'User Type'
                    )
        ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Duedinoi\UserBundle\Entity\User',
            'novalidate' => 'novalidate'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'duedinoi_userbundle_user';
    }

}
