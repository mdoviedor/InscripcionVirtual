<?php

namespace Fundeuis\EducacionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Fundeuis\EducacionBundle\Entity\Estudiantenf;
use Fundeuis\EducacionBundle\Entity\Ciudad;
use Fundeuis\EducacionBundle\Entity\Administrador;
use Fundeuis\EducacionBundle\Form\EstudiantenfType;
use Fundeuis\UserBundle\Entity\User;
use Fundeuis\EducacionBundle\Entity\Rol;

/**
 * Estudiantenf controller.
 *
 */
class EstudiantenfController extends Controller {

    const RUTACIUDAD = 'FundeuisEducacionBundle:Ciudad';
    const RUTAROL = 'FundeuisEducacionBundle:Rol';
    const RUTAUSER = 'FundeuisEducacionBundle:User';
    const RUTAESTUDIANTENF = 'FundeuisEducacionBundle:Estudiantenf';
    const RUTAADMINISTRADOR = 'FundeuisEducacionBundle:Administrador';

    /**
     * Lists all Estudiantenf entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FundeuisEducacionBundle:Estudiantenf')->findAll();

        return $this->render('FundeuisEducacionBundle:Estudiantenf:index.html.twig', array(
                    'entities' => $entities,
        ));
    }

    /**
     * Creates a new Estudiantenf entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new Estudiantenf();
        $ciudad = new Ciudad();
        $rol = new Rol();
        $user = new User();
        $autor = new Administrador();
        $userManager = $this->get('fos_user.user_manager'); // Instancia del manejador del bundle FOSUser
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
            $dep = $form->get('departamento')->getData();
            $nomciu = $form->get('ciudad')->getData();
            $email = $form->get('correoElectronico')->getData();
            $username = $form->get('documentoidentidad')->getData();
            $ciudad = $em->getRepository(self::RUTACIUDAD)->busquedaCiudad($dep, $nomciu);

            if ($ciudad) {

                $rol = $em->getRepository(self::RUTAROL)->findOneBy(array('nombre' => 'ROLE_ESTUDIANTENF'));
                $autor = $em->getRepository(self::RUTAADMINISTRADOR)->findOneBy(array('documentoidentidad' => $a));

                $user->setEmail($email);
                $user->setUsername($username);
                $user->setEnabled(true);
                $user->setPlainPassword($username);
                $user->r($rol->getNombre());

                $userManager->updateUser($user); //Actualizacion del contenido del manejador
                $this->getDoctrine()->getManager()->flush();

                $user = $em->getRepository(self::RUTAUSER)->findOneBy(array('username' => $username));

                $entity->setRol($rol);
                $entity->setUser($user);
                $entity->setAutor($autor);
                $entity->setCiudad($ciudad[0]);
                $em->persist($entity);
                $em->flush();

                $mensaje = "El estudiante de educación no formal se registro con exito";
                $this->get('session')->getFlashBag()->add(//Mensaje flash. Notificación de exito de la operación.
                        'notice', $mensaje
                );

                return $this->redirect($this->generateUrl('administrador_educacion_estudiantenf_show', array('id' => $entity->getId())));
            } else {
                $mensaje = "La ciudad que esta indicando no existe, intentelo de nuevo";
                $this->get('session')->getFlashBag()->add(//Mensaje flash. Notificación de exito de la operación.
                        'error', $mensaje
                );
            }
        } else {
            $mensaje = "Los datos ingresados son incorrectos. Intentelo de nuevo.";
            $this->get('session')->getFlashBag()->add(//Mensaje flash. Notificación de exito de la operación.
                    'error', $mensaje
            );
        }

        return $this->render('FundeuisEducacionBundle:Estudiantenf:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Estudiantenf entity.
     *
     * @param Estudiantenf $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Estudiantenf $entity) {
        $form = $this->createForm(new EstudiantenfType(null), $entity, array(
            'action' => $this->generateUrl('administrador_educacion_estudiantenf_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Estudiantenf entity.
     *
     */
    public function newAction() {
        $entity = new Estudiantenf();
        $form = $this->createCreateForm($entity);

        return $this->render('FundeuisEducacionBundle:Estudiantenf:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Estudiantenf entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FundeuisEducacionBundle:Estudiantenf')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Estudiantenf entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FundeuisEducacionBundle:Estudiantenf:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Estudiantenf entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FundeuisEducacionBundle:Estudiantenf')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Estudiantenf entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FundeuisEducacionBundle:Estudiantenf:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Estudiantenf entity.
     *
     * @param Estudiantenf $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Estudiantenf $entity) {
        $form = $this->createForm(new EstudiantenfType($entity->getUser()->getEmail(), $entity->getCiudad()->getNombre(), $entity->getCiudad()->getDepartamento()->getNombre()), $entity, array(
            'action' => $this->generateUrl('administrador_educacion_estudiantenf_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Estudiantenf entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $ciudad = new Ciudad();
        $rol = new Rol();
        $user = new User();
        $autor = new Administrador();
        $userManager = $this->get('fos_user.user_manager'); // Instancia del manejador del bundle FOSUser
        /*
         * Obtener username de la sesion para determinar el autor
         */
        $userManagerAutor = $this->get('security.context')->getToken()->getUser();
        $a = $userManagerAutor->getUsername();
        /*
         *
         */

        $entity = $em->getRepository('FundeuisEducacionBundle:Estudiantenf')->find($id);
        $user = $em->getRepository('FundeuisUserBundle:User')->find($entity->getUser()->getId());

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Estudiantenf entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $dep = $editForm->get('departamento')->getData();
            $nomciu = $editForm->get('ciudad')->getData();
            $email = $editForm->get('correoElectronico')->getData();
            $username = $editForm->get('documentoidentidad')->getData();
            $ciudad = $em->getRepository(self::RUTACIUDAD)->busquedaCiudad($dep, $nomciu);
            if ($ciudad) {
                $autor = $em->getRepository(self::RUTAADMINISTRADOR)->findOneBy(array('documentoidentidad' => $a));

                $user->setEmail($email);
                $user->setUsername($username);

                $userManager->updateUser($user); //Actualizacion del contenido del manejador
                $this->getDoctrine()->getManager()->flush();

                $entity->setAutor($autor);
                $entity->setCiudad($ciudad[0]);

                $em->persist($entity);
                $em->flush();

                $mensaje = "Actualización exitosa";
                $this->get('session')->getFlashBag()->add(//Mensaje flash. Notificación de exito de la operación.
                        'notice', $mensaje
                );

                return $this->redirect($this->generateUrl('administrador_educacion_estudiantenf_edit', array('id' => $id)));
            } else {
                $mensaje = "La ciudad que esta indicando no existe, intentelo de nuevo";
                $this->get('session')->getFlashBag()->add(//Mensaje flash. Notificación de exito de la operación.
                        'error', $mensaje
                );
            }
        } else {
            $mensaje = "Los datos ingresados son incorrectos. Intentelo de nuevo.";
            $this->get('session')->getFlashBag()->add(//Mensaje flash. Notificación de exito de la operación.
                    'error', $mensaje
            );
        }

        return $this->render('FundeuisEducacionBundle:Estudiantenf:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Estudiantenf entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FundeuisEducacionBundle:Estudiantenf')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Estudiantenf entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('administrador_educacion_estudiantenf'));
    }

    /**
     * Creates a form to delete a Estudiantenf entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('administrador_educacion_estudiantenf_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => "btn btn-danger btn-lg", 'onClick' => 'return ConfirmarAccion();')))
                        ->getForm()
        ;
    }

}
