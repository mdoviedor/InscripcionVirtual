<?php

namespace Fundeuis\EducacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Fundeuis\EducacionBundle\Entity\Curso;
use Fundeuis\EducacionBundle\Form\CursoType;
use Fundeuis\EducacionBundle\Entity\Administrador;
use Fundeuis\EducacionBundle\Entity\UsuarioCurso;

/**
 * Curso controller.
 *
 */
class CursoController extends Controller {

    const RUTAADMINISTRADOR = 'FundeuisEducacionBundle:Administrador';
    const RUTAUSUARIOCURSO = 'FundeuisEducacionBundle:UsuarioCurso';

    /**
     * Lists all Curso entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FundeuisEducacionBundle:Curso')->findAll();

        return $this->render('FundeuisEducacionBundle:Curso:index.html.twig', array(
                    'entities' => $entities,
        ));
    }

    /**
     * Creates a new Curso entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new Curso();
        $autor = new Administrador();
        /*
         * Obtener username de la sesion para determinar el autor
         */
        $userManagerAutor = $this->get('security.context')->getToken()->getUser();
        $a = $userManagerAutor->getUsername();
        /*
         *
         */
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $autor = $em->getRepository(self::RUTAADMINISTRADOR)->findOneBy(array('documentoidentidad' => $a));
            $entity->setAutor($autor);

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('administrador_educacion_curso_show', array('id' => $entity->getId())));
        }

        return $this->render('FundeuisEducacionBundle:Curso:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Curso entity.
     *
     * @param Curso $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Curso $entity) {
        $form = $this->createForm(new CursoType(), $entity, array(
            'action' => $this->generateUrl('administrador_educacion_curso_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear', 'attr' => array('class' => "btn btn-success btn-lg")));

        return $form;
    }

    /**
     * Displays a form to create a new Curso entity.
     *
     */
    public function newAction() {
        $entity = new Curso();
        $form = $this->createCreateForm($entity);

        return $this->render('FundeuisEducacionBundle:Curso:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Curso entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();
        $usuarioCurso = new UsuarioCurso();
        $preinscritos = new UsuarioCurso();

        $entity = $em->getRepository('FundeuisEducacionBundle:Curso')->find($id);
        $usuarioCurso = $em->getRepository(self::RUTAUSUARIOCURSO)->findBy(array('curso' => $id, 'estado' => true), array('fecharegistro' => 'DESC'));
        $preinscritos = $em->getRepository(self::RUTAUSUARIOCURSO)->findBy(array('curso' => $id, 'estado' => false), array('fecharegistro' => 'DESC'));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Curso entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FundeuisEducacionBundle:Curso:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
                    'usuarioCurso' => $usuarioCurso,
                    'preinscritos' => $preinscritos
        ));
    }

    /**
     * Displays a form to edit an existing Curso entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FundeuisEducacionBundle:Curso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Curso entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FundeuisEducacionBundle:Curso:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Curso entity.
     *
     * @param Curso $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Curso $entity) {
        $form = $this->createForm(new CursoType(), $entity, array(
            'action' => $this->generateUrl('administrador_educacion_curso_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar', 'attr' => array('class' => "btn btn-success btn-lg")));

        return $form;
    }

    /**
     * Edits an existing Curso entity.
     *
     */
    public function updateAction(Request $request, $id) {
        /*
         * Obtener username de la sesion para determinar el autor
         */
        $userManagerAutor = $this->get('security.context')->getToken()->getUser();
        $a = $userManagerAutor->getUsername();
        /*
         *
         */

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FundeuisEducacionBundle:Curso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Curso entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $autor = $em->getRepository(self::RUTAADMINISTRADOR)->findOneBy(array('documentoidentidad' => $a));
            $entity->setAutor($autor);
            $em->flush();

            return $this->redirect($this->generateUrl('administrador_educacion_curso_edit', array('id' => $id)));
        }

        return $this->render('FundeuisEducacionBundle:Curso:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Curso entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FundeuisEducacionBundle:Curso')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Curso entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('administrador_educacion_curso'));
    }

    /**
     * Creates a form to delete a Curso entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('administrador_educacion_curso_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Eliminar', 'attr' => array('class' => "btn btn-danger btn-lg", 'onClick' => 'return ConfirmarAccion();')))
                        ->getForm()
        ;
    }

}
