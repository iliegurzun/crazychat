<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Duedinoi\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Duedinoi\AdminBundle\Entity\Gallery;
use Duedinoi\AdminBundle\Form\GalleryType;
use Duedinoi\AdminBundle\Form\UploadifyType;
use Duedinoi\AdminBundle\Entity\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Description of ImageController
 *
 * @author Ilie
 */
class ImageController extends Controller
{
    /**
     * Lists all Country entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DuedinoiAdminBundle:Image')->findWithUser();
        
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities,
            $this->get('request')->query->get('page', 1)/*page number*/,
            20/*limit per page*/
        );

        return $this->render('DuedinoiAdminBundle:Image:index.html.twig', array(
            'entities' => $pagination
        ));
    }
    
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('DuedinoiAdminBundle:Image')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Image entity.');
        }

        $em->remove($entity);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add(
            'notice', 'The Image has been deleted!'
        );

        return $this->redirect($this->generateUrl('image'));
    }
}
