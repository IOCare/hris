<?php

namespace Hris\OrganisationunitBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Hris\OrganisationunitBundle\Entity\Organisationunit;
use Hris\OrganisationunitBundle\Form\OrganisationunitType;

/**
 * Organisationunit controller.
 *
 * @Route("/organisationunit")
 */
class OrganisationunitController extends Controller
{

    /**
     * Lists all Organisationunit entities.
     *
     * @Secure(roles="ROLE_ORGANISATIONUNIT_ORGANISATIONUNIT_LIST,ROLE_USER")
     *
     * @Route("/", name="organisationunit")
     * @Route("/list", name="organisationunit_list")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('HrisOrganisationunitBundle:Organisationunit')->findAll();
        $delete_forms = NULL;
        foreach($entities as $entity) {
            $delete_form= $this->createDeleteForm($entity->getId());
            $delete_forms[$entity->getId()] = $delete_form->createView();
        }

        return array(
            'entities' => $entities,
            'delete_forms' => $delete_forms,
        );
    }
    /**
     * Creates a new Organisationunit entity.
     *
     * @Secure(roles="ROLE_ORGANISATIONUNIT_ORGANISATIONUNIT_CREATE")
     *
     * @Route("/", name="organisationunit_create")
     * @Method("POST")
     * @Template("HrisOrganisationunitBundle:Organisationunit:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Organisationunit();
        $form = $this->createForm(new OrganisationunitType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('organisationunit_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Organisationunit entity.
     *
     * @Secure(roles="ROLE_ORGANISATIONUNIT_ORGANISATIONUNIT_CREATE")
     *
     * @Route("/new", name="organisationunit_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Organisationunit();
        $form   = $this->createForm(new OrganisationunitType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Organisationunit entity.
     *
     * @Secure(roles="ROLE_ORGANISATIONUNIT_ORGANISATIONUNIT_SHOW")
     *
     * @Route("/{id}", name="organisationunit_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HrisOrganisationunitBundle:Organisationunit')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Organisationunit entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Organisationunit entity.
     *
     * @Secure(roles="ROLE_ORGANISATIONUNIT_ORGANISATIONUNIT_EDIT")
     *
     * @Route("/{id}/edit", name="organisationunit_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HrisOrganisationunitBundle:Organisationunit')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Organisationunit entity.');
        }

        $editForm = $this->createForm(new OrganisationunitType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Organisationunit entity.
     *
     * @Secure(roles="ROLE_ORGANISATIONUNIT_ORGANISATIONUNIT_EDIT")
     *
     * @Route("/{id}", name="organisationunit_update")
     * @Method("PUT")
     * @Template("HrisOrganisationunitBundle:Organisationunit:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HrisOrganisationunitBundle:Organisationunit')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Organisationunit entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new OrganisationunitType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('organisationunit_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Organisationunit entity.
     *
     * @Secure(roles="ROLE_ORGANISATIONUNIT_ORGANISATIONUNIT_DELETE")
     *
     * @Route("/{id}", name="organisationunit_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('HrisOrganisationunitBundle:Organisationunit')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Organisationunit entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('organisationunit'));
    }

    /**
     * Creates a form to delete a Organisationunit entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
