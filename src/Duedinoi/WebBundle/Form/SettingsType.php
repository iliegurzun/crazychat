<?php
namespace Duedinoi\WebBundle\Form;

use Duedinoi\UserBundle\Entity\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of SettingsType
 *
 * @author Ilie
 */
class SettingsType extends AbstractType
{
    protected $translator;
    
    public function __construct($translator) 
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder
            ->add('voteNotification', 'checkbox', array(
                'property_path' => 'profile.voteNotification',
                'label'         => $this->translator->trans('profile.vote_notification'),
                'required'      => false
            ))
            ->add('commentNotification', 'checkbox', array(
                'property_path' => 'profile.commentNotification',
                'label'         => $this->translator->trans('profile.comment_notification'),
                'required'      => false
            ))
            ->add('messageNotification', 'checkbox', array(
                'property_path' => 'profile.messageNotification',
                'label'         => $this->translator->trans('profile.message_notification'),
                'required'      => false
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Duedinoi\UserBundle\Entity\User',
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'user_settings';
    }
}
