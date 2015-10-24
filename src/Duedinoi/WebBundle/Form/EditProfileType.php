<?php
namespace Duedinoi\WebBundle\Form;

use Duedinoi\UserBundle\Entity\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

/**
 * Class RegisterType
 * @package Duedinoi\WebBundle
 */
class EditProfileType extends AbstractType
{
    protected $translator;
    
    public function __construct($translator) 
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder
                
                ->add('username', 'text', array(
                    'label'         => $this->translator->trans('profile.username')
                ))
                ->add('email', 'text', array(
                    'label'         => $this->translator->trans('profile.email')
                ))
                ->add('dateOfBirth', 'date', array(
                    'property_path' => 'profile.dateOfBirth',
                    'label'         => $this->translator->trans('register.birth_date'),
                    'widget'        => 'choice',
                    'format'        => 'dd MM yyyy',
                    'years'         => array(1990, 1991, 1992, 1993, 1994),
                    'placeholder'   => array(
                        'year'      => $this->translator->trans('register.date.year'),
                        'month'     => $this->translator->trans('register.date.month'),
                        'day'       => $this->translator->trans('register.date.day')
                    )
                ))
                ->add('country', 'entity', array(
                    'label'         => $this->translator->trans('profile.country'),
                    'class'         => 'DuedinoiAdminBundle:Country',
                    'empty_value'   => $this->translator->trans('register.choose_country')
                ))
                ->add('city', 'text', array(
                    'property_path' => 'profile.city',
                    'label'         => $this->translator->trans('profile.city'),
                    'attr'          => array(
                        'class'         => 'form-control',
                        'placeholder'   => $this->translator->trans('register.choose_city'),
                    )
                ))
                ->add('gender', 'choice', array(
                    'property_path' => 'profile.gender',
                    'expanded'      => false,
                    'multiple'      => false,
                    'choices'       => array(
                        Profile::GENDER_MALE => $this->translator->trans('register.sex.male'),
                        Profile::GENDER_FEMALE => $this->translator->trans('register.sex.female')
                    )
                ))
                
                ->add('relationship', 'choice', array(
                    'property_path'     => 'profile.relationship',
                    'choices'           => array(
                        Profile::STATUS_SINGLE              => $this->translator->trans('relationship.single'),
                        Profile::STATUS_IN_A_RELATIONSHIP   => $this->translator->trans('relationship.relationship'),
                        Profile::STATUS_MARRIED              => $this->translator->trans('relationship.married'),
                        Profile::STATUS_DIVORCED            => $this->translator->trans('relationship.divorced'),
                        Profile::STATUS_ENGAGED             => $this->translator->trans('relationship.engaged'),
                        Profile::STATUS_SEPARATED           => $this->translator->trans('relationship.separated'),
                        Profile::STATUS_WIDOWED             => $this->translator->trans('relationship.widowed'),
                    )
                ))
                ->add('sign', 'choice', array(
                    'property_path'     => 'profile.sign',
                    'choices'           => array(
                        Profile::SIGN_ARIES         => $this->translator->trans('sign.aries'),
                        Profile::SIGN_TAURUS        => $this->translator->trans('sign.taurus'),
                        Profile::SIGN_GEMINI        => $this->translator->trans('sign.gemini'),
                        Profile::SIGN_CANCER        => $this->translator->trans('sign.cancer'),
                        Profile::SIGN_LEO           => $this->translator->trans('sign.leo'),
                        Profile::SIGN_VIRGO         => $this->translator->trans('sign.virgo'),
                        Profile::SIGN_LIBRA         => $this->translator->trans('sign.libra'),
                        Profile::SIGN_SCORPIO       => $this->translator->trans('sign.scorpio'),
                        Profile::SIGN_SAGITTARIUS   => $this->translator->trans('sign.sagittarius'),
                        Profile::SIGN_CAPRICORN     => $this->translator->trans('sign.capricorn'),
                        Profile::SIGN_AQUARIUS      => $this->translator->trans('sign.aquarius'),
                        Profile::SIGN_PISCES        => $this->translator->trans('sign.pisces'),
                    )
                ))
                ->add('hobby', 'textarea', array(
                    'property_path' => 'profile.hobby'
                ))
                ->add('studies', 'textarea', array(
                    'property_path' => 'profile.studies'
                ))
                ->add('description', 'textarea', array(
                    'property_path' => 'profile.description'
                ))
                ->add('current_password', 'password', array(
                    'label'             => 'form.current_password',
                    'translation_domain'=> 'FOSUserBundle',
                    'mapped'            => false,
                    'constraints'       => new UserPassword(),
                    'required'          => false
                ))
                ->add('plainPassword', 'repeated', array(
                'type'              => 'password',
                'options'           => array('translation_domain' => 'FOSUserBundle'),
                'first_options'     => array('label' => 'form.new_password'),
                'second_options'    => array('label' => 'form.new_password_confirmation'),
                'invalid_message'   => 'fos_user.password.mismatch',
                'required'          => false
            ))
            ;
    }
    
    public function getName()
    {
        return 'edit_profile';
    }
}
