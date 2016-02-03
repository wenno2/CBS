<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Period;
use AppBundle\Form\PeriodType;

/**
 * Period controller.
 *
 * @Route("/period")
 */
class PeriodController extends Controller
{

    /**
     * Lists all Period entities.
     *
     * @Route("/", name="period")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Period')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Period entity.
     *
     * @Route("/", name="period_create")
     * @Method("POST")
     * @Template("AppBundle:Period:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Period();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('period_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Period entity.
     *
     * @param Period $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Period $entity)
    {
        $form = $this->createForm(new PeriodType(), $entity, array(
            'action' => $this->generateUrl('period_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Period entity.
     *
     * @Route("/new", name="period_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Period();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Period entity.
     *
     * @Route("/{id}", name="period_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Period')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Period entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Period entity.
     *
     * @Route("/{id}/edit", name="period_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        
        // CLONE
        $entity = $em->getRepository('AppBundle:Period')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Period entity.');
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
    * Creates a form to edit a Period entity.
    *
    * @param Period $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Period $entity)
    {
                        
        // CLONE $entity for a new entity
        $form = $this->createForm(new PeriodType(), $entity, array(
            'action' => $this->generateUrl('period_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Period entity.
     *
     * @Route("/{id}", name="period_update")
     * @Method("PUT")
     * @Template("AppBundle:Period:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Period')->find($id);
        
        $em->detach($entity);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Period entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            
            $em->merge($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('period_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Period entity.
     *
     * @Route("/{id}", name="period_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Period')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Period entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('period'));
    }

    /**
     * Creates a form to delete a Period entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('period_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
