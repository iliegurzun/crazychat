<?php

namespace Duedinoi\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Duedinoi\AdminBundle\Form\ImageType;
use Duedinoi\UserBundle\Entity\Profile;
use Doctrine\ORM\EntityRepository;

class UserType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $years = new \DateTime('-18 years');
        $list = range(1920, (int)$years->format('Y'));
        
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
                ->add('dateOfBirth', 'date', array(
                    'property_path' => 'profile.dateOfBirth',
                    'label'  => 'Date Of Birth',
                    'widget' => 'choice',
                    'format'    => 'dd MM yyyy',
                    'years'  => array_reverse($list),
                    'placeholder' => array(
                        'year' => 'Year',
                        'month' => 'Month',
                        'day' => 'Day'
                    ),
                    'label_attr' => array(
                        'class' => 'col-lg-4 control-label'
                    ),
                    'attr' => array(
                        'placeholder' => 'Date Of Birth'
                    )
                ))
                ->add('gender', 'choice', array(
                    'property_path' => 'profile.gender',
                    'expanded' => true,
                    'multiple' => false,
                    'choices' => array(
                        Profile::GENDER_MALE => 'Male',
                        Profile::GENDER_FEMALE => 'Female'
                    ),
                    'label_attr' => array(
                        'class' => 'col-lg-4 control-label'
                    )
                ))
                ->add('country', 'entity', array(
                    'class' => 'DuedinoiAdminBundle:Country',
                    'empty_value' => 'Country',
                    'label_attr' => array(
                        'class' => 'col-lg-4 control-label'
                    ),
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => 'Country'
                    )
                ))
                ->add('city', 'text', array(
                    'property_path' => 'profile.city',
                    'label'         => 'City',
                    'label_attr' => array(
                        'class' => 'col-lg-4 control-label'
                    ),
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => 'City'
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
                ->add('recruiter', 'entity', array(
                    'label' => 'Recruiter',
                    'label_attr' => array(
                        'class' => 'col-lg-4 control-label'
                    ),
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => 'Recruiter',
                        'disabled' => 'disabled'
                    ),
                    'empty_value' => 'Recruiter...',
                    'class' => \Duedinoi\UserBundle\Entity\User::class
                ))
                ->add('referral', 'url', array(
                    'label' => 'Referral',
                    'label_attr' => array(
                        'class' => 'col-lg-4 control-label'
                    ),
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => 'Referral'
                    )
                ))
                ->add('converter', 'entity', array(
                    'label' => 'Converter',
                    'label_attr' => array(
                        'class' => 'col-lg-4 control-label'
                    ),
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => 'Converter',
                    ),
                    'empty_value' => 'Converter...',
                    'class' => \Duedinoi\UserBundle\Entity\User::class,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->andWhere('u.roles LIKE :admin')
                            ->setParameter('admin', '%ROLE_ADMIN%')
                        ;
                    },
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
                ->add('site', \Symfony\Component\Form\Extension\Core\Type\UrlType::class, array(
                    'label'     => 'Site',
                    'label_attr' => array(
                        'class' => 'col-lg-4 control-label'
                    ),
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => 'Site'
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
            'novalidate' => 'novalidate',
            'validation_groups' => array('admin')
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'duedinoi_userbundle_user';
    }

}
