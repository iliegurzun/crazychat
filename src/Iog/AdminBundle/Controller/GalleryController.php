<?php

namespace Iog\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Iog\AdminBundle\Entity\Gallery;
use Iog\AdminBundle\Form\GalleryType;
use Iog\AdminBundle\Form\UploadifyType;
use Iog\AdminBundle\Entity\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Gallery controller.
 *
 */
class GalleryController extends Controller
{

    /**
     * Lists all Gallery entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('IogAdminBundle:Gallery')->findAll();
        
        $deleteForms = array();
        
        foreach($entities as $menu) {
            $deleteForms[$menu->getId()] = $this->createDeleteForm($menu->getId())->createView();
        }
        
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities,
            $this->get('request')->query->get('page', 1)/*page number*/,
            5/*limit per page*/
        );

        return $this->render('IogAdminBundle:Gallery:index.html.twig', array(
            'entities' => $pagination,
            'delete_forms' => $deleteForms,
            'sidebar_entities' => $entities
            
        ));
    }
    /**
     * Creates a new Gallery entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Gallery();
        $form = $this->createCreateForm($entity);
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('IogAdminBundle:Gallery')->findAll();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('gallery_edit', array('id' => $entity->getId())));
        }

        return $this->render('IogAdminBundle:Gallery:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'entities' => $entities
        ));
    }

    /**
    * Creates a form to create a Gallery entity.
    *
    * @param Gallery $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Gallery $entity)
    {
        $form = $this->createForm(new GalleryType(), $entity, array(
            'action' => $this->generateUrl('gallery_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Gallery entity.
     *
     */
    public function newAction()
    {
        $entity = new Gallery();
        $form   = $this->createCreateForm($entity);
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('IogAdminBundle:Menu')->findAll();
        return $this->render('IogAdminBundle:Gallery:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Gallery entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IogAdminBundle:Gallery')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Gallery entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('IogAdminBundle:Gallery:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Gallery entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IogAdminBundle:Gallery')->find($id);
        
        $entities = $em->getRepository('IogAdminBundle:Gallery')->findAll();
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Menu entity.');
        }

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Gallery entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('IogAdminBundle:Gallery:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'entities'    => $entities
        ));
    }

    /**
    * Creates a form to edit a Gallery entity.
    *
    * @param Gallery $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Gallery $entity)
    {
        $form = $this->createForm(new GalleryType(), $entity, array(
            'action' => $this->generateUrl('gallery_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }
    /**
     * Edits an existing Gallery entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IogAdminBundle:Gallery')->find($id);
        $entities = $em->getRepository('IogAdminBundle:Gallery')->findAll();
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Gallery entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('gallery_edit', array('id' => $id)));
        }

        return $this->render('IogAdminBundle:Gallery:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'entities' => $entities
        ));
    }
    /**
     * Deletes a Gallery entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('IogAdminBundle:Gallery')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Gallery entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('gallery'));
    }

    /**
     * Creates a form to delete a Gallery entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('gallery_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    public function uploadPhotosAction($gallery_id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $gallery = $em->getRepository('IogAdminBundle:Gallery')->find($gallery_id);
        
        $files = $this->get('iog.admin.photo_upload')->initializeFileUpload($request);
        
        foreach ($files as $file) {
            if ($file->saved == 'true') {
                $image = new Image();
                if($request->request->get('description')) {
                    $image->setDescription($request->request->get('description'));
                }
                $image_form = $this->createForm(new UploadifyType(), $image);
                $uploadedFileTmp = new UploadedFile($file->file_path, $file->name, $file->type, $file->size, false, true);
                $image_form->bind(array('Filedata' => $uploadedFileTmp));
                if ($image_form->isValid()) {
                    $gallery->addGalleryImage($image);
                    $em->persist($image);
                    $em->persist($gallery);
                    $em->flush();
//                    $content = $request->request->get('description');

                    $file->fileId = $image->getId();
                    $file->htmlTemplate = $this->renderView('IogAdminBundle:Gallery:single_image.html.twig', array('image' => $image, 'gallery' => $gallery));
                }
            }
        }

        return new Response(json_encode(array('files' => $files)));
        
    }
    
    public function removeImageAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        if($request->isMethod('post')) {
            $image = $request->request->get('image_id');
            $image = $em->getRepository('IogAdminBundle:Image')->find($image);
            $gallery = $request->request->get('gallery_id');
            $gallery = $em->getRepository('IogAdminBundle:Gallery')->find($gallery);
            $gallery->removeGalleryImage($image);
            $em->persist($gallery);
//            $em->remove($image);
            $em->flush();

            return new JsonResponse(array('success' => true));
        }
        return new JsonResponse(array('success' => false));
    }
    
    public function updateImageDescAction($image_id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $image = $em->getRepository('IogAdminBundle:Image')->find($image_id);
        $description = $request->request->get('description');
        $image->setDescription($description);
        $em->persist($image);
        $em->flush();
        return new JsonResponse(array('success' => true, 'image_id' => $image->getId()));
    }
}
