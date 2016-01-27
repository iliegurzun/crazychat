<?php

namespace Duedinoi\UserBundle\Form;

use Duedinoi\UserBundle\EventListener\UserEventSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Duedinoi\AdminBundle\Form\ImageType;
use Duedinoi\UserBundle\Entity\Profile;
use Doctrine\ORM\EntityRepository;

class UserType extends AbstractType {

    protected $isAjax = false;

    public function __construct($isAjax = false)
    {
        $this->isAjax = $isAjax;
    }

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
                ->add('enabled', 'checkbox', array(
                    'label' => 'Enabled',
                    'label_attr' => array(
                        'class' => 'col-lg-4 control-label'
                    ),
                    'attr' => array(
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
                ->add('membership', 'choice', array(
                    'choices' => array(
                        'base' => 'Base',
                        'silver'=> 'Silver',
                        'gold' => 'Oro',
                        'vip' => 'VIP'
                    ),
                    'label' => 'Membership',
                    'label_attr' => array(
                        'class' => 'col-lg-4 control-label'
                    ),
                    'attr' => array(
                        'class' => 'form-control',
                    ),
                    'placeholder' => 'Membership'
                ))
        ;

        $builder->addEventSubscriber(new UserEventSubscriber());
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $defaults = array(
            'data_class' => 'Duedinoi\UserBundle\Entity\User',
            'novalidate' => 'novalidate',
            'allow_extra_fields' => true
        );

        if (!$this->isAjax) {
            $defaults['validation_groups'] = array('admin');
        }
        $resolver->setDefaults($defaults);
    }

    /**
     * @return string
     */
    public function getName() {
        return 'duedinoi_userbundle_user';
    }

}
