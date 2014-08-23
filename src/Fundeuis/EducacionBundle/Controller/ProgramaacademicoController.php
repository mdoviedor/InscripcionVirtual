<?php

namespace Fundeuis\EducacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Fundeuis\EducacionBundle\Entity\Programaacademico;
use Fundeuis\EducacionBundle\Form\ProgramaacademicoType;

/**
 * Programaacademico controller.
 *
 */
class ProgramaacademicoController extends Controller {

    /**
     * Lists all Programaacademico entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FundeuisEducacionBundle:Programaacademico')->findAll();

        return $this->render('FundeuisEducacionBundle:Programaacademico:index.html.twig', array(
                    'entities' => $entities,
        ));
    }

    /**
     * Creates a new Programaacademico entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new Programaacademico();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('administrador_configuracion_programaacademico_show', array('id' => $entity->getId())));
        }

        return $this->render('FundeuisEducacionBundle:Programaacademico:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Programaacademico entity.
     *
     * @param Programaacademico $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Programaacademico $entity) {
        $form = $this->createForm(new ProgramaacademicoType(), $entity, array(
            'action' => $this->generateUrl('administrador_configuracion_programaacademico_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Programaacademico entity.
     *
     */
    public function newAction() {
        $entity = new Programaacademico();
        $form = $this->createCreateForm($entity);

        return $this->render('FundeuisEducacionBundle:Programaacademico:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Programaacademico entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FundeuisEducacionBundle:Programaacademico')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Programaacademico entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FundeuisEducacionBundle:Programaacademico:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Programaacademico entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FundeuisEducacionBundle:Programaacademico')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Programaacademico entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FundeuisEducacionBundle:Programaacademico:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Programaacademico entity.
     *
     * @param Programaacademico $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Programaacademico $entity) {
        $form = $this->createForm(new ProgramaacademicoType(), $entity, array(
            'action' => $this->generateUrl('administrador_configuracion_programaacademico_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Programaacademico entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FundeuisEducacionBundle:Programaacademico')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Programaacademico entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('administrador_configuracion_programaacademico_edit', array('id' => $id)));
        }

        return $this->render('FundeuisEducacionBundle:Programaacademico:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Programaacademico entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FundeuisEducacionBundle:Programaacademico')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Programaacademico entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('administrador_configuracion_programaacademico'));
    }

    /**
     * Creates a form to delete a Programaacademico entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('administrador_configuracion_programaacademico_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => "btn btn-danger btn-lg", 'onClick' => 'return ConfirmarAccion();')))
                        ->getForm()
        ;
    }

}
