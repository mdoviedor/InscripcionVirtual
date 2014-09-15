<?php

namespace Fundeuis\EducacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Fundeuis\EducacionBundle\Entity\UsuarioCurso;
use Fundeuis\EducacionBundle\Form\UsuarioCursoType;
use Fundeuis\EducacionBundle\Entity\Curso;
use Fundeuis\EducacionBundle\Entity\Estudiantenf;

/**
 * UsuarioCurso controller.
 *
 */
class UsuarioCursoController extends Controller {

    const CURSO = 'FundeuisEducacionBundle:Curso';
    const USUARIOCURSO = 'FundeuisEducacionBundle:UsuarioCurso';
    const ESTUDIANTENF = 'FundeuisEducacionBundle:Estudiantenf';

    /**
     * Lists all UsuarioCurso entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FundeuisEducacionBundle:UsuarioCurso')->findAll();

        return $this->render('FundeuisEducacionBundle:UsuarioCurso:index.html.twig', array(
                    'entities' => $entities,
        ));
    }

    /**
     * Creates a new UsuarioCurso entity.
     * Recibe el $id, correpondiente al id del usuario a matricular
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param type $id
     * @return type
     */
    public function createAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $entity = new UsuarioCurso();
        $curso = new Curso();
        $estudiantenf = new Estudiantenf();

        $estudiantenf = $em->getRepository(self::ESTUDIANTENF)->find($id);

        $this->idEstudiantenf = $id;
        $form = $this->createCreateForm($entity, $id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $c = $form->get('curso')->getData();
            $curso = $em->getRepository(self::CURSO)->find($c);
            $fechaRegistro = new \DateTime("now");
            $entity->setFecharegistro($fechaRegistro);
            $entity->setEstudiantenf($estudiantenf);
            $entity->setCurso($curso);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('administrador_educacion_estudiantenf_show', array('id' => $entity->getEstudiantenf()->getId())));
        }


        return $this->render('FundeuisEducacionBundle:UsuarioCurso:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                    'estudiantenf' => $estudiantenf
        ));
    }

    /**
     * Creates a form to create a UsuarioCurso entity.
     *
     * @param UsuarioCurso $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(UsuarioCurso $entity, $id) {

        $em = $this->getDoctrine()->getManager();
        $curso = new Curso();
        $curso = $em->getRepository(self::USUARIOCURSO)->buscarCursosAno(); // Busca los cursos ofertados de los ultimos dos años. 
        $form = $this->createForm(new UsuarioCursoType($curso), $entity, array(
            'action' => $this->generateUrl('administrador_educacion_usuariocurso_create', array('id' => $id)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create', 'attr' => array('class' => "btn btn-success btn-lg")));

        return $form;
    }

    /**
     * Displays a form to create a new UsuarioCurso entity.
     *
     */
    public function newAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = new UsuarioCurso();
        $estudiantenf = new Estudiantenf();
        $esMatriculado1 = new UsuarioCurso();
        $esMatriculado2 = new UsuarioCurso();
        $form = $this->createCreateForm($entity, $id);

        $estudiantenf = $em->getRepository(self::ESTUDIANTENF)->find($id);
        $esMatriculado1 = $em->getRepository(self::USUARIOCURSO)->buscarMatriculaUsuarioActiva1($id);
        $esMatriculado2 = $em->getRepository(self::USUARIOCURSO)->buscarMatriculaUsuarioActiva2($id);


        return $this->render('FundeuisEducacionBundle:UsuarioCurso:new.html.twig', array(
                    'estudiantenf' => $estudiantenf,
                    'entity' => $entity,
                    'form' => $form->createView(),
                    'esMatriculado1' => $esMatriculado1,
                    'esMatriculado2' => $esMatriculado2,
        ));
    }

    /**
     * Finds and displays a UsuarioCurso entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FundeuisEducacionBundle:UsuarioCurso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UsuarioCurso entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FundeuisEducacionBundle:UsuarioCurso:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing UsuarioCurso entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FundeuisEducacionBundle:UsuarioCurso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UsuarioCurso entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FundeuisEducacionBundle:UsuarioCurso:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a UsuarioCurso entity.
     *
     * @param UsuarioCurso $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(UsuarioCurso $entity) {
        $form = $this->createForm(new UsuarioCursoType(), $entity, array(
            'action' => $this->generateUrl('administrador_educacion_usuariocurso_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => "btn btn-success btn-lg")));

        return $form;
    }

    /**
     * Edits an existing UsuarioCurso entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FundeuisEducacionBundle:UsuarioCurso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UsuarioCurso entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('administrador_educacion_usuariocurso_edit', array('id' => $id)));
        }

        return $this->render('FundeuisEducacionBundle:UsuarioCurso:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a UsuarioCurso entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FundeuisEducacionBundle:UsuarioCurso')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find UsuarioCurso entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('administrador_educacion_usuariocurso'));
    }

    /**
     * Creates a form to delete a UsuarioCurso entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('administrador_educacion_usuariocurso_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => "btn btn-danger btn-lg", 'onClick' => 'return ConfirmarAccion();')))
                        ->getForm()
        ;
    }

}
