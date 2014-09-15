<?php

namespace Fundeuis\UsuarioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Fundeuis\UsuarioBundle\Entity\Administrador;
use Fundeuis\UsuarioBundle\Form\AdministradorType;
use Fundeuis\UserBundle\Entity\User;
use Fundeuis\UsuarioBundle\Entity\Rol;

/**
 * Administrador controller.
 * @author Marlon Oviedo Rueda <marlon.oviedo5@gmail.com>
 */
class AdministradorController extends Controller {

    const RUTAROL = 'FundeuisUsuarioBundle:Rol';
    const RUTAUSER = 'FundeuisUsuarioBundle:User';
    const RUTAADMINISTRADOR = 'FundeuisUsuarioBundle:Administrador';

    /**
     * Lists all Administrador entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FundeuisUsuarioBundle:Administrador')->findAll();

        return $this->render('FundeuisUsuarioBundle:Administrador:index.html.twig', array(
                    'entities' => $entities,
        ));
    }

    /**
     * Creates a new Administrador entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new Administrador();
        $rol = new Rol();
        $user = new User();
        $autor = new User();
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

            $email = $form->get('correoElectronico')->getData();
            $username = $form->get('documentoidentidad')->getData();
            $r = $form->get('rol')->getData();
            $rol = $em->getRepository(self::RUTAROL)->find($r);

            $user->setEmail($email);
            $user->setUsername($username);
            $user->setEnabled(true);
            $user->setPlainPassword($username);
            $user->r($rol->getNombre());

            $userManager->updateUser($user); //Actualizacion del contenido del manejador
            $this->getDoctrine()->getManager()->flush();

            $user = $em->getRepository(self::RUTAUSER)->findOneBy(array('username' => $username));
            $autor = $em->getRepository(self::RUTAUSER)->findOneBy(array('username' => $a));
            $entity->setUser($user);
            $entity->setAutor($autor);
            $fechaRegistro = new \DateTime("now");
            $entity->setFecharegistro($fechaRegistro);

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('administrador_configuracion_administrador_show', array('id' => $entity->getId())));
        }

        return $this->render('FundeuisUsuarioBundle:Administrador:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Administrador entity.
     *
     * @param Administrador $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Administrador $entity) {
        $form = $this->createForm(new AdministradorType(null), $entity, array(
            'action' => $this->generateUrl('administrador_configuracion_administrador_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear', 'attr' => array('class' => "btn btn-success btn-lg")));

        return $form;
    }

    /**
     * Displays a form to create a new Administrador entity.
     *
     */
    public function newAction() {
        $entity = new Administrador();
        $form = $this->createCreateForm($entity);

        return $this->render('FundeuisUsuarioBundle:Administrador:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Administrador entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = new Administrador();
        $autor = new Administrador();

        $entity = $em->getRepository('FundeuisUsuarioBundle:Administrador')->find($id);
        $autor = $em->getRepository('FundeuisUsuarioBundle:Administrador')->findOneBy(array('documentoidentidad' => $entity->getAutor()->getUsername()));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Administrador entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FundeuisUsuarioBundle:Administrador:show.html.twig', array(
                    'autor' => $autor,
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Administrador entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FundeuisUsuarioBundle:Administrador')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Administrador entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FundeuisUsuarioBundle:Administrador:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Administrador entity.
     *
     * @param Administrador $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Administrador $entity) {

        $form = $this->createForm(new AdministradorType($entity->getUser()->getEmail()), $entity, array(
            'action' => $this->generateUrl('administrador_configuracion_administrador_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar', 'attr' => array('class' => "btn btn-success btn-lg")));

        return $form;
    }

    /**
     * Edits an existing Administrador entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $rol = new Rol();
        $user = new User();
        $autor = new User();
        $userManager = $this->get('fos_user.user_manager'); // Instancia del manejador del bundle FOSUser
        
        /*
         * Obtener username de la sesion para determinar el autor
         */
        $userManagerAutor = $this->get('security.context')->getToken()->getUser();
        $a = $userManagerAutor->getUsername();
        /*
         *
         */

        $entity = $em->getRepository('FundeuisUsuarioBundle:Administrador')->find($id);
        $user = $em->getRepository('FundeuisUserBundle:User')->find($entity->getUser()->getId());

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Administrador entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $email = $editForm->get('correoElectronico')->getData();
            $username = $editForm->get('documentoidentidad')->getData();
            $r = $editForm->get('rol')->getData();
            $rol = $em->getRepository(self::RUTAROL)->find($r);

            $user->setEmail($email);
            $user->setUsername($username);
            //$user->setPlainPassword($username);
            $user->r($rol->getNombre());

            $userManager->updateUser($user); //Actualizacion del contenido del manejador
            $this->getDoctrine()->getManager()->flush();

            $user = $em->getRepository(self::RUTAUSER)->findOneBy(array('username' => $username));
            $autor = $em->getRepository(self::RUTAUSER)->findOneBy(array('username' => $a));
            $entity->setUser($user);
            $entity->setAutor($autor);
            
            $em->flush();

            return $this->redirect($this->generateUrl('administrador_configuracion_administrador_edit', array('id' => $id)));
        }

        return $this->render('FundeuisUsuarioBundle:Administrador:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Administrador entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FundeuisUsuarioBundle:Administrador')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Administrador entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('administrador_configuracion_administrador'));
    }

    /**
     * Creates a form to delete a Administrador entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('administrador_configuracion_administrador_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Eliminar', 'attr' => array('class' => "btn btn-danger btn-lg", 'onClick' => 'return ConfirmarAccion();')))
                        ->getForm()
        ;
    }

}
