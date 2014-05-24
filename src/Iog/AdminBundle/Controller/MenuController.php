<?php

namespace Iog\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Iog\AdminBundle\Entity\Menu;
use Iog\AdminBundle\Form\MenuType;
use Iog\AdminBundle\Entity\MenuItem;
use Iog\AdminBundle\Form\MenuItemType;
use Iog\AdminBundle\Form\MenuItemPageType;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Menu controller.
 *
 */
class MenuController extends Controller {

    /**
     * Lists all Menu entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('IogAdminBundle:Menu')->findAll();
        
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
        

        return $this->render('IogAdminBundle:Menu:index.html.twig', array(
                    'entities' => $pagination,
                    'delete_forms' => $deleteForms
        ));
    }

    /**
     * Creates a new Menu entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new Menu();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
			$this->get('session')->getFlashBag()->add(
                            'notice', 'The menu has been successfully created!'
                    );

            return $this->redirect($this->generateUrl('menu_edit', array('id' => $entity->getId())));
        }

        return $this->render('IogAdminBundle:Menu:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Menu entity.
     *
     * @param Menu $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Menu $entity) {
        $form = $this->createForm(new MenuType(), $entity, array(
            'action' => $this->generateUrl('menu_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Menu entity.
     *
     */
    public function newAction() {
        $entity = new Menu();
        $form = $this->createCreateForm($entity);
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('IogAdminBundle:Menu')->findAll();

        return $this->render('IogAdminBundle:Menu:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                    'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Menu entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IogAdminBundle:Menu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Menu entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('IogAdminBundle:Menu:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),));
    }

    /**
     * Displays a form to edit an existing Menu entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IogAdminBundle:Menu')->find($id);
        $entities = $em->getRepository('IogAdminBundle:Menu')->findAll();
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Menu entity.');
        }
        
        $menuItems = $em->getRepository('IogAdminBundle:MenuItem')->findBy(array('menu'=>$id ));

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('IogAdminBundle:Menu:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
                    'entities' => $entities,
                    'menu_items' => $menuItems
        ));
    }

    /**
     * Creates a form to edit a Menu entity.
     *
     * @param Menu $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Menu $entity) {
        $form = $this->createForm(new MenuType(), $entity, array(
            'action' => $this->generateUrl('menu_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * Edits an existing Menu entity.
     *
     */
    public function updateAction(Request $request, $id) {
//        var_dump($request->request->all());die;
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IogAdminBundle:Menu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Menu entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        if ($menuName = $request->request->get('menu')) {
            $entity->setName($menuName);
            $em->persist($entity);
            $this->setPosition($em, $request->request->get('menu_items'));
            $em->flush();

            return new \Symfony\Component\HttpFoundation\JsonResponse(array(
                'success' => true,
            ));
			
//			$this->get('session')->getFlashBag()->add(
//                            'notice', 'The menu has been successfully created!'
//                    );
        }

        return $this->render('IogAdminBundle:Menu:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Menu entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('IogAdminBundle:Menu')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Menu entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('menu'));
    }

    /**
     * Creates a form to delete a Menu entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('menu_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

    public function menuItemAction($menu_id, Request $request) {
        $em = $this->getDoctrine()->getManager();

        $menu = $em->getRepository('IogAdminBundle:Menu')->find($menu_id);
        if (!$menu) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Menu does not exist');
        }
        $menuItem = new MenuItem();
        $form = $this->createForm(new MenuItemType(), $menuItem);
        $items = $em->getRepository('IogAdminBundle:MenuItem')->findBy(array('menu' => $menu));

        if ($request->isMethod('post')) {
            $form->bind($request);
            $menuItem->setMenu($menu);
            $em->persist($menuItem);
            $em->flush();
            return $this->redirect($this->generateUrl('menu_edit', array(
                                'id' => $menu_id
            )));
        }

        return $this->render('IogAdminBundle:Menu:menu_items.html.twig', array(
                    'form' => $form->createView(),
                    'items' => $items,
                    'menu' => $menu
        ));
    }

    private function setPosition($em, $hierarchy, $parentId = null) {
        foreach ($hierarchy as $newPosition => $vars) {
            if (isset($vars['children'])) {
                $this->setPosition($em, $vars['children'], $vars['id']);
            }

            $menuItem = $em->getRepository('IogAdminBundle:MenuItem')->find($vars['id']);
            $menuItem->setPosition($newPosition);

            if (!is_null($parentId)) {
                $menuItemParent = $em->getRepository('IogAdminBundle:MenuItem')->find($parentId);
                $menuItem->setParent($menuItemParent);
            } else {
                $menuItem->setParent(null);
            }

            $em->persist($menuItem);
        }
    }
    
    public function addMenuItemAction($id, Request $request)
    {
        if($request->isMethod('post')) {
            
            $em = $this->getDoctrine()->getManager();
            $menu = $em->getRepository('IogAdminBundle:Menu')->find($id);
            if(!$menu) {
                throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
            }
            
            if($request->request->get('menu_item') !=='') {
                $menuItem = new MenuItem();
                $menuItem->setMenu($menu);
                $menuItem->setTitle($request->request->get('menu_item'));
                $em->persist($menuItem);
                $em->flush();
                return new \Symfony\Component\HttpFoundation\JsonResponse(array(
                    'success' => true
                ));
            }
        }
        return new \Symfony\Component\HttpFoundation\JsonResponse(array(
                    'success' => false
                ));
    }
    
    public function removeMenuItemAction(Request $request)
    {
        $menuitem_id = $request->request->get('menu_item_id');
        $em = $this->getDoctrine()->getManager();
        $menuItem = $em->getRepository('IogAdminBundle:MenuItem')->find($menuitem_id);
        
        if($request->isMethod('POST')) {
            $menu = $menuItem->getMenu();
            $menu->removeItem($menuItem);
            $em->persist($menu);
            $em->remove($menuItem);
            $em->flush();
            
            return new \Symfony\Component\HttpFoundation\JsonResponse(array(
               'success' => true
            ));
        }
        return new \Symfony\Component\HttpFoundation\JsonResponse(array('success' => false));
    }
    
    public function getEditModalAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $menuItem = $request->request->get('menu_item_id');
        
        $menuItem = $em->getRepository('IogAdminBundle:MenuItem')->find($menuItem);
        
        $title = 'Edit '. $menuItem->getTitle(). ' item';
        
        $form = $this->createForm(new \Iog\AdminBundle\Form\MenuItemPageType(), $menuItem);
        
        return new \Symfony\Component\HttpFoundation\JsonResponse(array(
            'content' => $this->renderView('IogAdminBundle:Menu:menu_item_modal.html.twig', array(
                            'menu_item' => $menuItem,
                            'title' => $title,
                            'form' => $form->createView()
                        ))
            ));
    }
    
    public function submitEditModalAction($menuitem_id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $menuItem = $em->getRepository('IogAdminBundle:MenuItem')->find($menuitem_id);
        
        if($request->isMethod('post')) {
            $form = $this->createForm(new MenuItemPageType(), $menuItem);
            
            parse_str($request->request->get('form_data'), $data);
            $form->bind($data);
            
            if($form->isValid()) {
            
                $em->persist($menuItem);

                $em->flush();
            
                return new JsonResponse(array('success' => true));
            }
        }
        return new JsonResponse(array('success' => false));
    }

}
