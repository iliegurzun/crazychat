<?php
/**
 * Created by PhpStorm.
 * User: Ilie
 * Date: 25/1/2016
 * Time: 10:06 PM
 */

namespace Duedinoi\UserBundle\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        // Tells the dispatcher that you want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return array(
            FormEvents::PRE_SUBMIT   => 'onPreSubmit',
            FormEvents::POST_SUBMIT  => 'onPostSubmit',
            FormEvents::POST_SET_DATA => 'preSetData'
        );
    }

    public function preSetData(FormEvent $event)
    {
        $user = $event->getData();
        $form = $event->getForm();
        switch ($user->getRole()) {
            case 'ROLE_ROBOT':
                $form
                    ->remove('email')
                    ->remove('dateOfBirth')
                    ->remove('plainPassword')
                ;
                break;
            case 'ROLE_ADMIN':
                $form
                    ->remove('dateOfBirth')
                    ->remove('membership')
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
                    ));
                ;
                break;
            default:
                $form
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
                    ));
                break;
        }
    }

    public function onPreSubmit(FormEvent $event)
    {
        $years = new \DateTime('-18 years');
        $list = range(1920, (int)$years->format('Y'));
        $user = $event->getData();
        $form = $event->getForm();
        switch ($user['role']) {
            case 'ROLE_ROBOT':
                $form
                    ->remove('email')
                    ->remove('dateOfBirth')
                    ->remove('plainPassword')
                    ;
                $credentials = uniqid('robot');
                $user['email'] = $credentials;
                $user['plainPassword'] = $credentials;
                break;
            case 'ROLE_ADMIN':
                $form
                    ->remove('dateOfBirth')
                    ->remove('membership')
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
                ;

                break;
            default:
                $form
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
                ;
                break;
        }

        return $form;
    }

    public function onPostSubmit(FormEvent $event)
    {
        $user = $event->getData();
        switch($user->getRole()) {
            case 'ROLE_ROBOT':
                    $user->setEmail($user->getUsername());
                    $user->setPlainPassword($user->getUsername());
                break;
        }

        return $event;
    }
}
