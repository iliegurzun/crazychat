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
                ->add('first_name', 'text', array(
                    'property_path' => 'profile.firstName',
                    'label' => 'First name',
                    'label_attr' => array(
                        'class' => 'col-lg-4 control-label'
                    ),
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => 'First name'
                    )
                ))
                ->add('last_name', 'text', array(
                    'property_path' => 'profile.lastName',
                    'label' => 'Last name',
                    'label_attr' => array(
                        'class' => 'col-lg-4 control-label'
                    ),
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => 'Last name'
                    )
                ))
                ->add('date_of_birth', 'date', array(
//                    'format' => 'Y-m-d',
                    'property_path' => 'profile.dateOfBirth',
                    'label' => 'Date of birth',
                    'label_attr' => array(
                        'class' => 'col-lg-4 control-label'
                    ),
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => 'Date of birth'
                    )
                ))
                ->add('image', new ImageType(), array(
                    'property_path' => 'profile.image',
                    'label' => 'Profile picture',
                        'label_attr' => array(
                            'class' => 'col-lg-4 control-label'
                        ),
//                        'attr' => array(
//                            'class' => 'btn btn-primary btn-file',
//                        )
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
