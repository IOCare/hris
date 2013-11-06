<?php

namespace Hris\IntergrationBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Hris\IntergrationBundle\Entity\DHISDataConnection;
use Hris\IntergrationBundle\Form\DHISDataConnectionType;

/**
 * DHISDataConnection controller.
 *
 * @Route("/dhisdataconnection")
 */
class DHISDataConnectionController extends Controller
{

    /**
     * Lists all DHISDataConnection entities.
     *
     * @Route("/", name="dhisdataconnection")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('HrisIntergrationBundle:DHISDataConnection')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new DHISDataConnection entity.
     *
     * @Route("/", name="dhisdataconnection_create")
     * @Method("POST")
     * @Template("HrisIntergrationBundle:DHISDataConnection:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new DHISDataConnection();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('dhisdataconnection_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a DHISDataConnection entity.
    *
    * @param DHISDataConnection $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(DHISDataConnection $entity)
    {
        $form = $this->createForm(new DHISDataConnectionType(), $entity, array(
            'action' => $this->generateUrl('dhisdataconnection_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('attr' => array('class' => 'btn'),'label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DHISDataConnection entity.
     *
     * @Route("/new", name="dhisdataconnection_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new DHISDataConnection();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a DHISDataConnection entity.
     *
     * @Route("/{id}", name="dhisdataconnection_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HrisIntergrationBundle:DHISDataConnection')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DHISDataConnection entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing DHISDataConnection entity.
     *
     * @Route("/{id}/edit", name="dhisdataconnection_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HrisIntergrationBundle:DHISDataConnection')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DHISDataConnection entity.');
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
    * Creates a form to edit a DHISDataConnection entity.
    *
    * @param DHISDataConnection $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DHISDataConnection $entity)
    {
        $form = $this->createForm(new DHISDataConnectionType(), $entity, array(
            'action' => $this->generateUrl('dhisdataconnection_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('attr' => array('class' => 'btn'),'label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DHISDataConnection entity.
     *
     * @Route("/{id}", name="dhisdataconnection_update")
     * @Method("PUT")
     * @Template("HrisIntergrationBundle:DHISDataConnection:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HrisIntergrationBundle:DHISDataConnection')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DHISDataConnection entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('dhisdataconnection_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a DHISDataConnection entity.
     *
     * @Route("/{id}", name="dhisdataconnection_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('HrisIntergrationBundle:DHISDataConnection')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DHISDataConnection entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('dhisdataconnection'));
    }

    /**
     * Creates a form to delete a DHISDataConnection entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dhisdataconnection_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('attr' => array('class' => 'btn'),'label' => 'Delete'))
            ->getForm()
        ;
    }
}
