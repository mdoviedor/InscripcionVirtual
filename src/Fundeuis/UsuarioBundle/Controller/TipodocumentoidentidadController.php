<?php

namespace Fundeuis\UsuarioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Fundeuis\UsuarioBundle\Entity\Tipodocumentoidentidad;
use Fundeuis\UsuarioBundle\Form\TipodocumentoidentidadType;

/**
 * Tipodocumentoidentidad controller.
 * @author Marlon Oviedo Rueda <marlon.oviedo5@gmail.com>
 */
class TipodocumentoidentidadController extends Controller
{

    /**
     * Lists all Tipodocumentoidentidad entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FundeuisUsuarioBundle:Tipodocumentoidentidad')->findAll();

        return $this->render('FundeuisUsuarioBundle:Tipodocumentoidentidad:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Tipodocumentoidentidad entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Tipodocumentoidentidad();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('administrador_configuracion_tipodocumentoidentidad_show', array('id' => $entity->getId())));
        }

        return $this->render('FundeuisUsuarioBundle:Tipodocumentoidentidad:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Tipodocumentoidentidad entity.
     *
     * @param Tipodocumentoidentidad $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Tipodocumentoidentidad $entity)
    {
        $form = $this->createForm(new TipodocumentoidentidadType(), $entity, array(
            'action' => $this->generateUrl('administrador_configuracion_tipodocumentoidentidad_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Tipodocumentoidentidad entity.
     *
     */
    public function newAction()
    {
        $entity = new Tipodocumentoidentidad();
        $form   = $this->createCreateForm($entity);

        return $this->render('FundeuisUsuarioBundle:Tipodocumentoidentidad:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Tipodocumentoidentidad entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FundeuisUsuarioBundle:Tipodocumentoidentidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tipodocumentoidentidad entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FundeuisUsuarioBundle:Tipodocumentoidentidad:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Tipodocumentoidentidad entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FundeuisUsuarioBundle:Tipodocumentoidentidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tipodocumentoidentidad entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FundeuisUsuarioBundle:Tipodocumentoidentidad:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Tipodocumentoidentidad entity.
    *
    * @param Tipodocumentoidentidad $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Tipodocumentoidentidad $entity)
    {
        $form = $this->createForm(new TipodocumentoidentidadType(), $entity, array(
            'action' => $this->generateUrl('administrador_configuracion_tipodocumentoidentidad_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Tipodocumentoidentidad entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FundeuisUsuarioBundle:Tipodocumentoidentidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tipodocumentoidentidad entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('administrador_configuracion_tipodocumentoidentidad_edit', array('id' => $id)));
        }

        return $this->render('FundeuisUsuarioBundle:Tipodocumentoidentidad:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Tipodocumentoidentidad entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FundeuisUsuarioBundle:Tipodocumentoidentidad')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Tipodocumentoidentidad entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('administrador_configuracion_tipodocumentoidentidad'));
    }

    /**
     * Creates a form to delete a Tipodocumentoidentidad entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('administrador_configuracion_tipodocumentoidentidad_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
