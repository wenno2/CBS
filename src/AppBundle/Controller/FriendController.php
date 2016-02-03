<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Friend;
use AppBundle\Form\FriendType;

/**
 * Friend controller.
 *
 * @Route("/friend")
 */
class FriendController extends Controller
{

    /**
     * Lists all Friend entities.
     *
     * @Route("/", name="friend")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Friend')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Friend entity.
     *
     * @Route("/", name="friend_create")
     * @Method("POST")
     * @Template("AppBundle:Friend:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Friend();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('friend_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Friend entity.
     *
     * @param Friend $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Friend $entity)
    {
        $form = $this->createForm(new FriendType(), $entity, array(
            'action' => $this->generateUrl('friend_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Friend entity.
     *
     * @Route("/new", name="friend_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Friend();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Friend entity.
     *
     * @Route("/{id}", name="friend_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Friend')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Friend entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Friend entity.
     *
     * @Route("/{id}/edit", name="friend_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Friend')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Friend entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Friend entity.
    *
    * @param Friend $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Friend $entity)
    {
        $form = $this->createForm(new FriendType(), $entity, array(
            'action' => $this->generateUrl('friend_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Friend entity.
     *
     * @Route("/{id}", name="friend_update")
     * @Method("PUT")
     * @Template("AppBundle:Friend:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Friend')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Friend entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('friend_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Friend entity.
     *
     * @Route("/{id}", name="friend_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Friend')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Friend entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('friend'));
    }

    /**
     * Creates a form to delete a Friend entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('friend_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
