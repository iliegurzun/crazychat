<?php
/**
 * Created by PhpStorm.
 * User: Ilie
 * Date: 16/1/2016
 * Time: 1:20 PM
 */

namespace Duedinoi\AdminBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RecruitedMemberType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('siteUser', 'text', array(
                'label' => 'Site User',
                'label_attr' => array(
                    'class' => 'col-lg-4 control-label'
                ),
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Site User'
                )
            ))
            ->add('age', 'number', array(
                'label' => 'Age',
                'label_attr' => array(
                    'class' => 'col-lg-4 control-label'
                ),
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Age'
                )
            ))
            ->add('location', 'text', array(
                'label' => 'Location',
                'label_attr' => array(
                    'class' => 'col-lg-4 control-label'
                ),
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Location'
                )
            ))
            ->add('siteName', 'text', array(
                'label' => 'Site Name',
                'label_attr' => array(
                    'class' => 'col-lg-4 control-label'
                ),
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Site Name'
                )
            ))
            ->add('comments', 'text', array(
                'label' => 'Comments',
                'label_attr' => array(
                    'class' => 'col-lg-4 control-label'
                ),
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Comments'
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
            ->add('recruiter', 'entity', array(
                'label' => 'Recruiter',
                'label_attr' => array(
                    'class' => 'col-lg-4 control-label'
                ),
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Recruiter',
                ),
                'empty_value' => 'Recruiter...',
                'class' => \Duedinoi\UserBundle\Entity\User::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.roles LIKE :admin')
                        ->setParameter('admin', '%ROLE_ADMIN%')
                        ;
                },
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
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Duedinoi\AdminBundle\Entity\RecruitedMember'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'duedinoi_adminbundle_recruited_member';
    }
}