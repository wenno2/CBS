<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Live;
use AppBundle\Entity\Pager;
use AppBundle\Form\LiveType;

/**
 * Live controller.
 *
 * @Route("/live")
 */
class LiveController extends Controller
{

    /**
     * Lists all Live entities.
     *
     * @Route("/", name="live")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Live')->findAll();

        return array(
            'entities' => $entities,
        );
    }



    /**
     * Lists all Live entities.
     *
     * @Route("/list/{page}", name="list_live")
     * @Method("GET")
     * @Template()
     */
    public function listAction($page)
    {

        $em = $this->getDoctrine()->getManager();
        // count instead
        $entitiesAll = $em->getRepository('AppBundle:Live')->findAll();
        $pager = new Pager(count($entitiesAll), $page);
        $offset = ($pager->Page - 1)*$pager->PageSize;
        $entities = $em->getRepository('AppBundle:Live')->findBy(array(),  array('id' => 'DESC'),1, $offset);


        return array(
            'entities' => $entities,
            'pager' => $pager
        );
    }
    /**
     * Creates a new Live entity.
     *
     * @Route("/", name="live_create")
     * @Method("POST")
     * @Template("AppBundle:Live:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Live();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('live_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Live entity.
     *
     * @param Live $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Live $entity)
    {
        $form = $this->createForm(LiveType::class, $entity, array(
            'action' => $this->generateUrl('live_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Live entity.
     *
     * @Route("/new", name="live_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Live();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Live entity.
     *
     * @Route("/{id}", name="live_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Live')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Live entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Live entity.
     *
     * @Route("/{id}/edit", name="live_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Live')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Live entity.');
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
    * Creates a form to edit a Live entity.
    *
    * @param Live $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Live $entity)
    {
        $form = $this->createForm(LiveType::class, $entity, array(
            'action' => $this->generateUrl('live_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Live entity.
     *
     * @Route("/{id}", name="live_update")
     * @Method("PUT")
     * @Template("AppBundle:Live:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Live')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Live entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('live_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Live entity.
     *
     * @Route("/{id}", name="live_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Live')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Live entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('live'));
    }

    /**
     * Creates a form to delete a Live entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('live_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
