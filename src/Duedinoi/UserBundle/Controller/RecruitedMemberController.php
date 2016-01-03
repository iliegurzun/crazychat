<?php

namespace Duedinoi\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Duedinoi\UserBundle\Entity\User;
use Duedinoi\UserBundle\Form\UserType;

/**
 * User controller.
 *
 */
class RecruitedMemberController extends Controller
{

    /**
     * Lists all User entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DuedinoiUserBundle:User')->findRecruited();

        $deleteForms = array();
        foreach($entities as $entity) {
            $deleteForms[$entity->getId()] = $this->createDeleteForm($entity->getId())->createView();
        }
        
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities,
            $this->get('request')->query->get('page', 1)/*page number*/,
            10/*limit per page*/
        );
        
        return $this->render('DuedinoiUserBundle:RecruitedMember:index.html.twig', array(
            'entities' => $pagination,
            'delete_forms' => $deleteForms
        ));
    }
    /**
     * Creates a new User entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new User();
        $entity->setEnabled(true);
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isValid()) {
            $entity
                ->setRecruiter($this->getUser());
            $em->persist($entity);
            $em->flush();
            if ('ROLE_USER' === $entity->getRole()) {
                return $this->redirect($this->generateUrl('duedinoi_my_profile', array(
                    '_want_to_be_this_user' => $entity->getUsername()
                )));
            }
            
            return $this->redirect($this->generateUrl('recruitedmember_edit', array('id' => $entity->getId())));
        }

        return $this->render('DuedinoiUserBundle:RecruitedMember:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a User entity.
    *
    * @param User $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(User $entity)
    {
        $form = $this->createForm(new UserType(), $entity, array(
            'action' => $this->generateUrl('recruitedmember_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new User entity.
     *
     */
    public function newAction()
    {
        $entity = new User();
        $entity->setEnabled(true);
        $form   = $this->createCreateForm($entity);

        return $this->render('DuedinoiUserBundle:RecruitedMember:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a User entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DuedinoiUserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RecruitedMember entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('DuedinoiUserBundle:RecruitedMember:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),    
        ));
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DuedinoiUserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RecruitedMember entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('DuedinoiUserBundle:RecruitedMember:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a User entity.
    *
    * @param User $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(User $entity)
    {
        $form = $this->createForm(new UserType(), $entity, array(
            'action' => $this->generateUrl('recruitedmember_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }
    /**
     * Edits an existing User entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DuedinoiUserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RecruitedMember entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('recruitedmember_edit', array('id' => $id)));
        }

        return $this->render('DuedinoiUserBundle:RecruitedMember:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a User entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DuedinoiUserBundle:User')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find RecruitedMember entity.');
            }

            $em->remove($entity);
            $em->flush();
        }
        

        return $this->redirect($this->generateUrl('admin'));
    }

    /**
     * Creates a form to delete a User entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('recruitedmember_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
