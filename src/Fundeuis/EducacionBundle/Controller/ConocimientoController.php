<?php

namespace Fundeuis\EducacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Fundeuis\EducacionBundle\Entity\Conocimiento;
use Fundeuis\EducacionBundle\Form\ConocimientoType;

/**
 * Conocimiento controller.
 *
 */
class ConocimientoController extends Controller
{

    /**
     * Lists all Conocimiento entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FundeuisEducacionBundle:Conocimiento')->findAll();

        return $this->render('FundeuisEducacionBundle:Conocimiento:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Conocimiento entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Conocimiento();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('administrador_configuracion_conocimiento_show', array('id' => $entity->getId())));
        }

        return $this->render('FundeuisEducacionBundle:Conocimiento:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Conocimiento entity.
     *
     * @param Conocimiento $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Conocimiento $entity)
    {
        $form = $this->createForm(new ConocimientoType(), $entity, array(
            'action' => $this->generateUrl('administrador_configuracion_conocimiento_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Conocimiento entity.
     *
     */
    public function newAction()
    {
        $entity = new Conocimiento();
        $form   = $this->createCreateForm($entity);

        return $this->render('FundeuisEducacionBundle:Conocimiento:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Conocimiento entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FundeuisEducacionBundle:Conocimiento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Conocimiento entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FundeuisEducacionBundle:Conocimiento:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Conocimiento entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FundeuisEducacionBundle:Conocimiento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Conocimiento entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FundeuisEducacionBundle:Conocimiento:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Conocimiento entity.
    *
    * @param Conocimiento $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Conocimiento $entity)
    {
        $form = $this->createForm(new ConocimientoType(), $entity, array(
            'action' => $this->generateUrl('administrador_configuracion_conocimiento_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Conocimiento entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FundeuisEducacionBundle:Conocimiento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Conocimiento entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('administrador_configuracion_conocimiento_edit', array('id' => $id)));
        }

        return $this->render('FundeuisEducacionBundle:Conocimiento:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Conocimiento entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FundeuisEducacionBundle:Conocimiento')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Conocimiento entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('administrador_configuracion_conocimiento'));
    }

    /**
     * Creates a form to delete a Conocimiento entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('administrador_configuracion_conocimiento_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => "btn btn-danger btn-lg", 'onClick' => 'return ConfirmarAccion();')))
            ->getForm()
        ;
    }
}
