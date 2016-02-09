<?php
/**
 * Created by PhpStorm.
 * User: Ilie
 * Date: 16/1/2016
 * Time: 1:19 PM
 */

namespace Duedinoi\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Duedinoi\AdminBundle\Entity\RecruitedMember;
use Duedinoi\AdminBundle\Form\RecruitedMemberType;


class RecruitedMemberController  extends Controller
{

    /**
     * Lists all Page entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $search = $this->getRequest()->get('search');

        $entities = $em->getRepository('DuedinoiAdminBundle:RecruitedMember')->findAllBySearch($search);

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

        return $this->render('DuedinoiAdminBundle:RecruitedMember:index.html.twig', array(
            'entities' => $pagination,
            'delete_forms' => $deleteForms,
            'sidebar_entities' => $entities
        ));
    }
    /**
     * Creates a new Page entity.
     *
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = new RecruitedMember();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('recruitedmember_edit', array('id' => $entity->getId())));
        }

        return $this->render('DuedinoiAdminBundle:RecruitedMember:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Page entity.
     *
     * @param Page $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(RecruitedMember $entity)
    {
        $form = $this->createForm(new RecruitedMemberType(), $entity, array(
            'action' => $this->generateUrl('recruitedmember_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Page entity.
     *
     */
    public function newAction()
    {
        $entity = new RecruitedMember();
        $form   = $this->createCreateForm($entity);
        $em = $this->getDoctrine()->getManager();

        return $this->render('DuedinoiAdminBundle:RecruitedMember:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Page entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DuedinoiAdminBundle:RecruitedMember')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RecruitedMember entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('DuedinoiAdminBundle:RecruitedMember:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Page entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DuedinoiAdminBundle:RecruitedMember')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RecruitedMember entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('DuedinoiAdminBundle:RecruitedMember:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Page entity.
     *
     * @param Page $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(RecruitedMember $entity)
    {
        $form = $this->createForm(new RecruitedMemberType(), $entity, array(
            'action' => $this->generateUrl('recruitedmember_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }
    /**
     * Edits an existing Page entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DuedinoiAdminBundle:RecruitedMember')->find($id);

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

        return $this->render('DuedinoiAdminBundle:RecruitedMember:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Page entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DuedinoiAdminBundle:RecruitedMember')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find RecruitedMember entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('recruitedmember'));
    }

    /**
     * Creates a form to delete a Page entity by id.
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
