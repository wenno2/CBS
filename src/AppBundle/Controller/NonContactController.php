<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\NonContact;
use AppBundle\Form\NonContactType;

/**
 * NonContact controller.
 *
 * @Route("/noncontact")
 */
class NonContactController extends Controller
{

    /**
     * Lists all NonContact entities.
     *
     * @Route("/", name="noncontact")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:NonContact')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new NonContact entity.
     *
     * @Route("/", name="noncontact_create")
     * @Method("POST")
     * @Template("AppBundle:NonContact:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new NonContact();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('noncontact_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a NonContact entity.
     *
     * @param NonContact $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(NonContact $entity)
    {
        $form = $this->createForm(new NonContactType(), $entity, array(
            'action' => $this->generateUrl('noncontact_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new NonContact entity.
     *
     * @Route("/new", name="noncontact_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new NonContact();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a NonContact entity.
     *
     * @Route("/{id}", name="noncontact_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:NonContact')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NonContact entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing NonContact entity.
     *
     * @Route("/{id}/edit", name="noncontact_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:NonContact')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NonContact entity.');
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
    * Creates a form to edit a NonContact entity.
    *
    * @param NonContact $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(NonContact $entity)
    {
        $form = $this->createForm(new NonContactType(), $entity, array(
            'action' => $this->generateUrl('noncontact_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing NonContact entity.
     *
     * @Route("/{id}", name="noncontact_update")
     * @Method("PUT")
     * @Template("AppBundle:NonContact:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:NonContact')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NonContact entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('noncontact_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a NonContact entity.
     *
     * @Route("/{id}", name="noncontact_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:NonContact')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find NonContact entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('noncontact'));
    }

    /**
     * Creates a form to delete a NonContact entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('noncontact_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
