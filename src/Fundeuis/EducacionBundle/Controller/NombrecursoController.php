<?php

namespace Fundeuis\EducacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Fundeuis\EducacionBundle\Entity\Nombrecurso;
use Fundeuis\EducacionBundle\Form\NombrecursoType;

/**
 * Nombrecurso controller.
 *
 */
class NombrecursoController extends Controller {

    /**
     * Lists all Nombrecurso entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FundeuisEducacionBundle:Nombrecurso')->findAll();

        return $this->render('FundeuisEducacionBundle:Nombrecurso:index.html.twig', array(
                    'entities' => $entities,
        ));
    }

    /**
     * Creates a new Nombrecurso entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new Nombrecurso();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('administrador_configuracion_nombrecurso_show', array('id' => $entity->getId())));
        }

        return $this->render('FundeuisEducacionBundle:Nombrecurso:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Nombrecurso entity.
     *
     * @param Nombrecurso $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Nombrecurso $entity) {
        $form = $this->createForm(new NombrecursoType(), $entity, array(
            'action' => $this->generateUrl('administrador_configuracion_nombrecurso_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Nombrecurso entity.
     *
     */
    public function newAction() {
        $entity = new Nombrecurso();
        $form = $this->createCreateForm($entity);

        return $this->render('FundeuisEducacionBundle:Nombrecurso:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Nombrecurso entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FundeuisEducacionBundle:Nombrecurso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Nombrecurso entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FundeuisEducacionBundle:Nombrecurso:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Nombrecurso entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FundeuisEducacionBundle:Nombrecurso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Nombrecurso entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FundeuisEducacionBundle:Nombrecurso:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Nombrecurso entity.
     *
     * @param Nombrecurso $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Nombrecurso $entity) {
        $form = $this->createForm(new NombrecursoType(), $entity, array(
            'action' => $this->generateUrl('administrador_configuracion_nombrecurso_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Nombrecurso entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FundeuisEducacionBundle:Nombrecurso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Nombrecurso entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('administrador_configuracion_nombrecurso_edit', array('id' => $id)));
        }

        return $this->render('FundeuisEducacionBundle:Nombrecurso:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Nombrecurso entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FundeuisEducacionBundle:Nombrecurso')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Nombrecurso entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('administrador_configuracion_nombrecurso'));
    }

    /**
     * Creates a form to delete a Nombrecurso entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('administrador_configuracion_nombrecurso_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => "btn btn-danger btn-lg", 'onClick' => 'return ConfirmarAccion();')))
                        ->getForm()
        ;
    }

}
