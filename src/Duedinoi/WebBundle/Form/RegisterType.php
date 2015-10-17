<?php
namespace Duedinoi\WebBundle\Form;

use Duedinoi\UserBundle\Entity\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Duedinoi\AdminBundle\Form\ImageType;

/**
 * Class RegisterType
 * @package Duedinoi\WebBundle
 */
class RegisterType extends AbstractType
{
    protected $translator;
    public function __construct($translator)
    {
        $this->translator = $translator;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('name', 'text', array(
                'label' => " ",
                'label_attr' => array(
                    'class' => 'col-lg-4 control-label'
                ),
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => $this->translator->trans('register.name')
                )
            ))
            ->add('email', 'email', array(
                'label' => ' ',
                'attr'  => array(
                    'class' => 'form-control',
                    'placeholder' => $this->translator->trans('register.email')
                )
            ))
            ->add('plainPassword', 'password', array(
                'required'  => true,
                'label'     => ' ',
                'attr'      => array(
                    'class' => 'form-control',
                    'placeholder' => $this->translator->trans('register.password')
                )
            ))
            ->add('dateOfBirth', 'date', array(
                'label'  => $this->translator->trans('register.birth_date'),
                'widget' => 'choice',
                'format'    => 'dd MM yyyy',
                'years'  => array(1990, 1991, 1992, 1993, 1994),
                'placeholder' => array(
                    'year' => $this->translator->trans('register.date.year'),
                    'month' => $this->translator->trans('register.date.month'),
                    'day' => $this->translator->trans('register.date.day')
                )
            ))
            ->add('gender', 'choice', array(
                'expanded' => true,
                'multiple' => false,
                'choices' => array(
                    Profile::GENDER_MALE => $this->translator->trans('register.sex.male'),
                    Profile::GENDER_FEMALE => $this->translator->trans('register.sex.female')
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
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'register';
    }
}