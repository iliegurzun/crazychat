<?php
/**
 * Created by PhpStorm.
 * User: Ilie
 * Date: 26/1/2016
 * Time: 10:27 PM
 */

namespace Duedinoi\UserBundle\Form;

use Duedinoi\UserBundle\Entity\User;
use Duedinoi\UserBundle\EventListener\UserEventSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Duedinoi\AdminBundle\Form\ImageType;
use Duedinoi\UserBundle\Entity\Profile;
use Doctrine\ORM\EntityRepository;

class UserSearchType extends AbstractType
{
    protected $filter = array();
    public function __construct($filter)
    {
        if (!$filter) {
            $filter = array();
        }
        $this->filter = $filter;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('role', 'choice', array(
                'choices' => array(
                    'ROLE_USER' => 'User',
                    'ROLE_ADMIN' => 'Admin',
                    'ROLE_ROBOT' => 'Robot'
                ),
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'User Type'
                ),
                'placeholder' => 'All types',
                'data' => isset($this->filter['role']) ? $this->filter['role'] : null
            ))
            ->add('email', 'text', array(
                'attr' => array(
                    'class' => 'form-control',
                ),
                'data' => isset($this->filter['email']) ? $this->filter['email'] : null
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'novalidate' => 'novalidate'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'search';
    }
}