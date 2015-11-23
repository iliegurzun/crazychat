<?php

namespace Duedinoi\WebBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of ContactType
 *
 * @author Ilie
 */
class ContactType extends AbstractType
{
    protected $translator;
    
    public function __construct($translator)
    {
        $this->translator = $translator;
    }

        public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('name', 'text', array(
                'label' => ' ',
                'attr'  => array(
                    'placeholder' => $this->translator->trans('contact.name')
                )
            ))
            ->add('email', 'email', array(
                'label' => ' ',
                'attr'  => array(
                    'placeholder' => $this->translator->trans('contact.email')
                )
            ))
            ->add('subject', 'text', array(
                'label' => ' ',
                'attr'  => array(
                    'placeholder' => $this->translator->trans('contact.subject')
                )
            ))
            ->add('message', 'textarea', array(
                'label' => ' ',
                'attr'  => array(
                    'placeholder' => $this->translator->trans('contact.message')
                )
            ))
            ;
    }

        /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) 
    {
        $resolver->setDefaults(array(
            'data_class'        => 'Duedinoi\AdminBundle\Entity\ContactMessage',
        ));
    }
    
    public function getName() {
        return 'contact';
    }
}
