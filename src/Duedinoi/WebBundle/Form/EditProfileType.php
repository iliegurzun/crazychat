<?php
namespace Duedinoi\WebBundle\Form;

use Duedinoi\UserBundle\Entity\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use FOS\UserBundle\Form\Type\ChangePasswordFormType;

/**
 * Class RegisterType
 * @package Duedinoi\WebBundle
 */
class EditProfileType extends RegisterType
{
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        parent::buildForm($builder, $options);
        $builder->remove('password')
                ->remove('gender')
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
                    'property_path' => 'profile.relationship',
                    'choices' => array(
                        Profile::STATUS_SINGLE    => $this->translator->trans('relationship.single'),
                        Profile::STATUS_MARIED    => $this->translator->trans('relationship.maried'),
                        Profile::STATUS_DIVORCED  => $this->translator->trans('relationship.divorced'),
                        Profile::STATUS_ENGAGED   => $this->translator->trans('relationship.engaged'),
                        Profile::STATUS_SEPARATED => $this->translator->trans('relationship.separated'),
                        Profile::STATUS_WIDOWED   => $this->translator->trans('relationship.widowed'),
                    )
                ))
                ->add('sign', 'choice', array(
                    'property_path' => 'profile.sign',
                    'choices' => array(
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
            ;
    }
}
