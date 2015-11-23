<?php

namespace Duedinoi\WebBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of CommentType
 *
 * @author Ilie
 */
class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder
            ->add('content')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) 
    {
        $resolver->setDefaults(array(
            'data_class'        => 'Duedinoi\WebBundle\Entity\Comment',
            'csrf_protection'   => false
        ));
    }

    public function getName() 
    {
        return 'comment';
    }
}
