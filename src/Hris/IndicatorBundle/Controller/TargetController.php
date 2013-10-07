<?php
/*
 *
 * Copyright 2012 Human Resource Information System
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 *
 * @since 2012
 * @author John Francis Mukulu <john.f.mukulu@gmail.com>
 * @author Ismail Y. Koleleni <ismailkoleleni@gmail.com>
 *
 */
namespace Hris\IndicatorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Hris\IndicatorBundle\Entity\Target;
use Hris\IndicatorBundle\Form\TargetType;

/**
 * Target controller.
 *
 * @Route("/target")
 */
class TargetController extends Controller
{

    /**
     * Lists all Target entities.
     *
     * @Route("/", name="target")
     * @Route("/list", name="target_list")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('HrisIndicatorBundle:Target')->findAll();
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
     * Creates a new Target entity.
     *
     * @Route("/", name="target_create")
     * @Method("POST")
     * @Template("HrisIndicatorBundle:Target:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Target();
        $form = $this->createForm(new TargetType(), $entity);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('target_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Target entity.
     *
     * @Route("/new", name="target_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Target();
        $form   = $this->createForm(new TargetType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Target entity.
     *
     * @Route("/{id}", requirements={"id"="\d+"}, name="target_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HrisIndicatorBundle:Target')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Target entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Target entity.
     *
     * @Route("/{id}/edit", name="target_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HrisIndicatorBundle:Target')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Target entity.');
        }

        $editForm = $this->createForm(new TargetType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Target entity.
     *
     * @Route("/{id}", name="target_update")
     * @Method("PUT")
     * @Template("HrisIndicatorBundle:Target:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HrisIndicatorBundle:Target')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Target entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new TargetType(), $entity);
        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('target_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Returns TargetFieldOptions json.
     *
     * @Secure(roles="ROLE_INDICATOR_TARGETFIELDOPTION_AJAX,ROLE_USER")
     *
     * @Route("/targetFieldOption.{_format}", requirements={"_format"="yml|xml|json"}, defaults={"_format"="json"}, name="target_targetfieldption")
     * @Method("POST")
     * @Template()
     */
    public function targetFieldOptionAction($_format)
    {
        $em = $this->getDoctrine()->getManager();
        $fieldid = $this->getRequest()->request->get('fieldid');
        $targetid = $this->getRequest()->request->get('targetid');
        $fieldOptionTargetNodes = NULL;

        // Fetch existing targets and field options belonging to target
        $fieldOptions = $em->getRepository('HrisFormBundle:FieldOption')->findBy(array('field'=>$fieldid));

        if(!empty($targetid) && !empty($fieldid)) {
            $queryBuilder = $this->getDoctrine()->getManager()->createQueryBuilder();
            $targetFieldOptions = $queryBuilder->select('targetFieldOption')
                ->from('HrisIndicatorBundle:TargetFieldOption','targetFieldOption')
                ->join('targetFieldOption.fieldOption','fieldOption')
                ->join('fieldOption.field','field')
                ->where('targetFieldOption.target=:targetid')
                ->andWhere('field.id=:fieldid')
                ->setParameters(array('targetid'=>$targetid,'fieldid'=>$fieldid))
                ->getQuery()->getResult();
            if(!empty($targetFieldOptions)) {
                foreach($targetFieldOptions as $targetFieldOptionKey=>$targetFieldOption) {
                    $fieldOptionTargetNodes[] = Array(
                        'name' => $targetFieldOption->getFieldOption()->getValue(),
                        'id' => $targetFieldOption->getFieldOption()->getId(),
                        'value' => $targetFieldOption->getValue()
                    );
                }
            }else {
                foreach($fieldOptions as $fieldOptionKey=>$fieldOption) {
                    $fieldOptionTargetNodes[] = Array(
                        'name' => $fieldOption->getValue(),
                        'id' => $fieldOption->getId(),
                        'value' => ''
                    );
                }
            }
        }else {
            foreach($fieldOptions as $fieldOptionKey=>$fieldOption) {
                $fieldOptionTargetNodes[] = Array(
                    'name' => $fieldOption->getValue(),
                    'id' => $fieldOption->getId(),
                    'value' => ''
                );
            }
        }

        $serializer = $this->container->get('serializer');

        return array(
            'entities' => $serializer->serialize($fieldOptionTargetNodes,$_format)
        );
    }

    /**
     * Deletes a Target entity.
     *
     * @Route("/{id}", name="target_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('HrisIndicatorBundle:Target')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Target entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('target'));
    }

    /**
     * Creates a form to delete a Target entity by id.
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
