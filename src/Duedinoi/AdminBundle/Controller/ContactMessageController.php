<?php

namespace Duedinoi\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Duedinoi\AdminBundle\Entity\ContactMessage;
use Duedinoi\AdminBundle\Form\ContactMessageType;

/**
 * ContactMessage controller.
 *
 */
class ContactMessageController extends Controller
{

    /**
     * Lists all ContactMessage entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DuedinoiAdminBundle:ContactMessage')->findAll();
        $deleteForms = array();
        
        foreach($entities as $entity) {
            $deleteForms[$entity->getId()] = $this->createDeleteForm($entity->getId())->createView();
        }
        
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities,
            $this->get('request')->query->get('page', 1)/*page number*/,
            5/*limit per page*/
        );

        return $this->render('DuedinoiAdminBundle:ContactMessage:index.html.twig', array(
            'entities' => $pagination,
            'delete_forms' => $deleteForms
        ));
    }
    /**
     * Creates a new ContactMessage entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new ContactMessage();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('contactmessage_edit', array('id' => $entity->getId())));
        }

        return $this->render('DuedinoiAdminBundle:ContactMessage:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a ContactMessage entity.
     *
     * @param ContactMessage $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ContactMessage $entity)
    {
        $form = $this->createForm(new ContactMessageType(), $entity, array(
            'action' => $this->generateUrl('contactmessage_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new ContactMessage entity.
     *
     */
    public function newAction()
    {
        $entity = new ContactMessage();
        $form   = $this->createCreateForm($entity);
        $em = $this->getDoctrine()->getManager();

        return $this->render('DuedinoiAdminBundle:ContactMessage:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ContactMessage entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DuedinoiAdminBundle:ContactMessage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContactMessage entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('DuedinoiAdminBundle:ContactMessage:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ContactMessage entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DuedinoiAdminBundle:ContactMessage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContactMessage entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('DuedinoiAdminBundle:ContactMessage:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a ContactMessage entity.
    *
    * @param ContactMessage $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ContactMessage $entity)
    {
        $form = $this->createForm(new ContactMessageType(), $entity, array(
            'action' => $this->generateUrl('contactmessage_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }
    /**
     * Edits an existing ContactMessage entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DuedinoiAdminBundle:ContactMessage')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContactMessage entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('contactmessage_edit', array('id' => $id)));
        }

        return $this->render('DuedinoiAdminBundle:ContactMessage:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a ContactMessage entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DuedinoiAdminBundle:ContactMessage')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ContactMessage entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('contactmessage'));
    }

    /**
     * Creates a form to delete a ContactMessage entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('contactmessage_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
