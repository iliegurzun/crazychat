<?php
namespace Duedinoi\WebBundle\Form;

use Duedinoi\UserBundle\Entity\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $years = new \DateTime('-18 years');
        $list = range(1920, (int)$years->format('Y'));
        $builder
            ->add('username', 'text', array(
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
                'property_path' => 'profile.dateOfBirth',
                'label'  => $this->translator->trans('register.birth_date'),
                'widget' => 'choice',
                'format'    => 'dd MM yyyy',
                'years'  => array_reverse($list),
                'placeholder' => array(
                    'year' => $this->translator->trans('register.date.year'),
                    'month' => $this->translator->trans('register.date.month'),
                    'day' => $this->translator->trans('register.date.day')
                )
            ))
            ->add('gender', 'choice', array(
                'property_path' => 'profile.gender',
                'expanded' => true,
                'multiple' => false,
                'choices' => array(
                    Profile::GENDER_MALE => $this->translator->trans('register.sex.male'),
                    Profile::GENDER_FEMALE => $this->translator->trans('register.sex.female')
                )
            ))
            ->add('country', 'entity', array(
                'class' => 'DuedinoiAdminBundle:Country',
                'empty_value' => $this->translator->trans('register.choose_country')
            ))
            ->add('city', 'text', array(
                'property_path' => 'profile.city',
                'label'         => ' ',
                'attr'          => array(
                    'class'         => 'form-control',
                    'placeholder'   => $this->translator->trans('register.choose_city'),
                )
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class'        => 'Duedinoi\UserBundle\Entity\User',
            'validation_groups' =>  array('registration'),
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'fos_user_registration';
    }
}