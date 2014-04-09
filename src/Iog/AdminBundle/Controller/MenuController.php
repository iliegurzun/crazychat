<?php

namespace Iog\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Iog\AdminBundle\Entity\Menu;
use Iog\AdminBundle\Form\MenuType;
use Iog\AdminBundle\Entity\MenuItem;
use Iog\AdminBundle\Form\MenuItemType;

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

        return $this->render('IogAdminBundle:Menu:index.html.twig', array(
                    'entities' => $entities,
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

            return $this->redirect($this->generateUrl('menu_show', array('id' => $entity->getId())));
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

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Menu entity.
     *
     */
    public function newAction() {
        $entity = new Menu();
        $form = $this->createCreateForm($entity);

        return $this->render('IogAdminBundle:Menu:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
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

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Menu entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('IogAdminBundle:Menu:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
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
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IogAdminBundle:Menu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Menu entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $menuForm = $this->createForm(new MenuType(), $entity);
        parse_str($request->request->get('menu'), $menu);
        $menuForm->bind($menu);
        var_dump($menuForm->getErrorsAsString());die;
        if ($menuForm->isValid()) {
            $em->persist($menuForm->getData());
            $em->flush();
            $this->setPosition($em, $request->request->get('menu_items'));
            die('1');

            return new Response('1');
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
                        ->add('submit', 'submit', array('label' => 'Delete'))
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
        var_dump($hierarchy);die;
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

}
