<?php

namespace Iog\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Iog\AdminBundle\Entity\Setting;
use Iog\AdminBundle\Form\SettingType;

/**
 * Setting controller.
 *
 */
class SettingController extends Controller
{

    /**
     * Lists all Setting entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('IogAdminBundle:Setting')->findAll();
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

        return $this->render('IogAdminBundle:Setting:index.html.twig', array(
            'entities' => $pagination,
            'delete_forms' => $deleteForms
        ));
    }
    /**
     * Creates a new Setting entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Setting();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('IogAdminBundle:Setting')->findAll();

        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('setting_show', array('id' => $entity->getId())));
        }

        return $this->render('IogAdminBundle:Setting:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'entities' => $entities
        ));
    }

    /**
    * Creates a form to create a Setting entity.
    *
    * @param Setting $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Setting $entity)
    {
        $form = $this->createForm(new SettingType(), $entity, array(
            'action' => $this->generateUrl('setting_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Setting entity.
     *
     */
    public function newAction()
    {
        $entity = new Setting();
        $form   = $this->createCreateForm($entity);
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('IogAdminBundle:Setting')->findAll();
        return $this->render('IogAdminBundle:Setting:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Setting entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IogAdminBundle:Setting')->find($id);

        $entities = $em->getRepository('IogAdminBundle:Setting')->findAll();
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Setting entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('IogAdminBundle:Setting:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        
            'entities' => $entities
        ));
    }

    /**
     * Displays a form to edit an existing Setting entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IogAdminBundle:Setting')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Setting entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        $entities = $em->getRepository('IogAdminBundle:Setting')->findAll();

        return $this->render('IogAdminBundle:Setting:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'entities' => $entities
        ));
    }

    /**
    * Creates a form to edit a Setting entity.
    *
    * @param Setting $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Setting $entity)
    {
        $form = $this->createForm(new SettingType(), $entity, array(
            'action' => $this->generateUrl('setting_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }
    /**
     * Edits an existing Setting entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IogAdminBundle:Setting')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Setting entity.');
        }
        $entities = $em->getRepository('IogAdminBundle:Setting')->findAll();

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('setting_edit', array('id' => $id)));
        }

        return $this->render('IogAdminBundle:Setting:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'entities' => $entities
        ));
    }
    /**
     * Deletes a Setting entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('IogAdminBundle:Setting')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Setting entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('setting'));
    }

    /**
     * Creates a form to delete a Setting entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('setting_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
