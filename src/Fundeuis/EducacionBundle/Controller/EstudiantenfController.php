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
use Fundeuis\EducacionBundle\Entity\UsuarioCurso;
use Fundeuis\EducacionBundle\Entity\Curso;

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
    const RUTAUSUARIOCURSO = 'FundeuisEducacionBundle:UsuarioCurso';
    const RUTACURSO = 'FundeuisEducacionBundle:Curso';

    /**
     * Muestra los estudiantes preinscritos a alguno de los cursos
     * 
     */
    public function inicioAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $usuarioCurso = new UsuarioCurso();
        $busqueda = new Estudiantenf();

        if ($request->getMethod() == 'POST') {
            $identificacion = $request->request->get('documentoIdentidad');
            $nombres = $request->request->get('nombres');
            $apellidos = $request->request->get('apellidos');
            if (!$identificacion || $identificacion == null) {
                $identificacion = 'XXXX';
            }
            if (!$nombres || $nombres == null) {
                $nombres = 'XXXX';
            }
            if (!$apellidos || $apellidos == null) {
                $apellidos = 'XXXX';
            }
            $busqueda = $em->getRepository(self::RUTAESTUDIANTENF)->busquedaFiltros($identificacion, $nombres, $apellidos);
        } else {
            $usuarioCurso = $em->getRepository(self::RUTAUSUARIOCURSO)->findBy(array('estado' => false));
        }


        return $this->render('FundeuisEducacionBundle:Estudiantenf:inicio.html.twig', array(
                    'usuarioCurso' => $usuarioCurso,
                    'busqueda' => $busqueda
        ));
    }

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

                $this->EnviarCorreoElectronico($mensaje . '<p>Usuario: ' . $username . '</p><p> Contraseña: ' . $username, 'Fundeuis - Registro Exitoso', $email);

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
        $form = $this->createForm(new EstudiantenfType(null, null, null), $entity, array(
            'action' => $this->generateUrl('administrador_educacion_estudiantenf_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create', 'attr' => array('class' => "btn btn-success btn-lg")));

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
        $usuarioCurso = new UsuarioCurso();

        $entity = $em->getRepository('FundeuisEducacionBundle:Estudiantenf')->find($id);
        $usuarioCurso = $em->getRepository(self::RUTAUSUARIOCURSO)->findBy(array('estudiantenf' => $id));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Estudiantenf entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FundeuisEducacionBundle:Estudiantenf:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
                    'usuarioCurso' => $usuarioCurso
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

        $form->add('submit', 'submit', array('label' => 'Actualizar', 'attr' => array('class' => "btn btn-success btn-lg")));

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

    /**
     * Recibe el id correspondiente al idusuariocurso del 
     * modelo UsuarioCurso. 
     * 
     * @param type $id
     */
    public function eliminarMatriculaAction($id, $origen) {
        $em = $this->getDoctrine()->getManager();
        $usuarioCurso = new UsuarioCurso();
        $usuarioCurso = $em->getRepository(self::RUTAUSUARIOCURSO)->find($id);

        $mensaje = 'Su matricula fué cancelada. Para mayor información comuníquese con nosotros.';
        $this->EnviarCorreoElectronico($mensaje, "Fundeuis - Cancelación de matricula.", $usuarioCurso->getEstudiantenf()->getUser()->getEmail());

        $em->remove($usuarioCurso);
        $em->flush();

        if ($origen == 'estudiantenf') {
            return $this->redirect($this->generateUrl('administrador_educacion_estudiantenf_show', array('id' => $usuarioCurso->getEstudiantenf()->getId())));
        } else {
            return $this->redirect($this->generateUrl('administrador_educacion_curso_show', array('id' => $usuarioCurso->getCurso()->getId())));
        }
    }

    public function cambiarEstadoMatriculaAction($id, $origen) {
        $em = $this->getDoctrine()->getManager();
        $usuarioCurso = new UsuarioCurso();
        $usuarioCurso = $em->getRepository(self::RUTAUSUARIOCURSO)->find($id);
        if ($usuarioCurso->getEstado()) {
            $usuarioCurso->setEstado(false);
            $mensaje = 'Su matricula en el curso: ' . $usuarioCurso->getCurso()->getNombrecurso()->getNombre() . ', cambio de estado. Para mayor información comuníquese con nosotros.';
        } else {
            $usuarioCurso->setEstado(true);
            $mensaje = 'Usted fué matriculado en el curso: ' . $usuarioCurso->getCurso()->getNombrecurso()->getNombre();
        }
        $this->EnviarCorreoElectronico($mensaje, "Fundeuis - Estado de la matricula.", $usuarioCurso->getEstudiantenf()->getUser()->getEmail());

        $em->persist($usuarioCurso);
        $em->flush();

        if ($origen == 'estudiantenf') {
            return $this->redirect($this->generateUrl('administrador_educacion_estudiantenf_show', array('id' => $usuarioCurso->getEstudiantenf()->getId())));
        } else {
            return $this->redirect($this->generateUrl('administrador_educacion_curso_show', array('id' => $usuarioCurso->getCurso()->getId())));
        }
    }

    /**
     * 
     * ACCIONES Y METODOS PARA LOS ESTUDIANTES.
     * 
     * 
     */

    /**
     * Preinscrion del usuario a new Estudiantenf entity.
     *
     */
    public function createPreinscripcionAction(Request $request) {
        $entity = new Estudiantenf();
        $ciudad = new Ciudad();
        $rol = new Rol();
        $user = new User();
        $autor = new Administrador();
        $userManager = $this->get('fos_user.user_manager'); // Instancia del manejador del bundle FOSUser


        $form = $this->createCreatePreinscripcionForm($entity);

        if ($request->getMethod() == "POST") {
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
                    $autor = $em->getRepository(self::RUTAADMINISTRADOR)->findOneBy(array('documentoidentidad' => 1000000));

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

                    $mensaje = "Usted se ha registrado con exito";
                    $this->get('session')->getFlashBag()->add(//Mensaje flash. Notificación de exito de la operación.
                            'notice', $mensaje
                    );
                    $this->EnviarCorreoElectronico($mensaje . '<p>Usuario: ' . $username . '</p><p> Contraseña: ' . $username, 'Fundeuis - Registro Exitoso', $email);

                    return $this->redirect($this->generateUrl('Fundeuis_index'));
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
        }

        return $this->render('FundeuisEducacionBundle:Estudiantenf:newPreinscripcion.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Estudiantenf entity. Preinscripcion 
     *
     * @param Estudiantenf $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreatePreinscripcionForm(Estudiantenf $entity) {
        $form = $this->createForm(new EstudiantenfType(null, null, null), $entity, array(
            'action' => $this->generateUrl('estudiantenf_educacion_estudiantenf_createPreinscripcion'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Registrarse', 'attr' => array('class' => "btn btn-success btn-lg")));

        return $form;
    }

    /**
     * Displays a form to create a new Estudiantenf entity.
     *
     */
    public function newPreinscripcionAction() {
        $entity = new Estudiantenf();
        $form = $this->createCreatePreinscripcionForm($entity);

        return $this->render('FundeuisEducacionBundle:Estudiantenf:newPreinscripcion.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    public function inicioPreinscripcionAction() {
        $entity = new UsuarioCurso();
        $buscarMatricula1 = new UsuarioCurso();
        $buscarMatricula2 = new UsuarioCurso();
        $estudiantenf = new Estudiantenf();
        $em = $this->getDoctrine()->getManager();

        /*
         * Obtener username de la sesion para determinar el autor
         */
        $userManager = $this->get('security.context')->getToken()->getUser();
        $u = $userManager->getUsername();
        /*
         *
         */

        $estudiantenf = $em->getRepository(self::RUTAESTUDIANTENF)->findOneBy(array('documentoidentidad' => $u));

        $entity = $em->getRepository(self::RUTAUSUARIOCURSO)->buscarCursosAnoActualVigente();
        $buscarMatricula1 = $em->getRepository(self::RUTAUSUARIOCURSO)->buscarMatriculaUsuarioActiva1($estudiantenf->getId());
        $buscarMatricula2 = $em->getRepository(self::RUTAUSUARIOCURSO)->buscarMatriculaUsuarioActiva2($estudiantenf->getId());
        return $this->render('FundeuisEducacionBundle:Estudiantenf:inicioPreinscripcion.html.twig', array(
                    'entity' => $entity,
                    'matriculaVigente1' => $buscarMatricula1,
                    'matriculaVigente2' => $buscarMatricula2
        ));
    }

    public function informacionPreinscripcionAction() {
        $usuarioCurso = new UsuarioCurso();
        $estudiantenf = new Estudiantenf();
        $em = $this->getDoctrine()->getManager();

        /*
         * Obtener username de la sesion para determinar el autor
         */
        $userManager = $this->get('security.context')->getToken()->getUser();
        $u = $userManager->getUsername();
        /*
         *
         */

        $estudiantenf = $em->getRepository(self::RUTAESTUDIANTENF)->findOneBy(array('documentoidentidad' => $u));
        $usuarioCurso = $em->getRepository(self::RUTAUSUARIOCURSO)->findBy(array('estudiantenf' => $estudiantenf->getId(), 'estado' => true));

        return $this->render('FundeuisEducacionBundle:Estudiantenf:informacionPreinscripcion.html.twig', array(
                    'usuarioCurso' => $usuarioCurso,
                    'estudiantenf' => $estudiantenf,
        ));
    }

    /**
     * Recibe el id correpondiente al idcurso del modelo Curso
     * 
     * @param type $id
     */
    public function preMatriculaAction($id) {
        $em = $this->getDoctrine()->getManager();
        $usuarioCurso = new UsuarioCurso();
        $curso = new Curso();
        $estudiantenf = new Estudiantenf();
        /*
         * Obtener username de la sesion para determinar el autor
         */
        $userManager = $this->get('security.context')->getToken()->getUser();
        $u = $userManager->getUsername();
        /*
         *
         */
        $usuarioCurso = $em->getRepository(self::RUTAUSUARIOCURSO)->comprobarCursosAnoActualVigente($id);
        if ($usuarioCurso) {  // Si el curso es vigente para matricularse
            $usuarioCurso = new UsuarioCurso();
            $curso = $em->getRepository(self::RUTACURSO)->find($id);
            $estudiantenf = $em->getRepository(self::RUTAESTUDIANTENF)->findOneBy(array('documentoidentidad' => $u));

            $usuarioCurso->setCurso($curso);
            $usuarioCurso->setEstudiantenf($estudiantenf);
            $usuarioCurso->setFecharegistro(new \DateTime('now'));
            $usuarioCurso->setEstado(false);

            $em->persist($usuarioCurso);
            $em->flush();

            $mensaje = "Se ha realizado la respectiva preinscripción. Usted debe "
                    . "enviar una foto con fondo azul, tarjeta de identidad y recibo"
                    . " de consignación al correo electrónico educacion@fundeuis.com "
                    . "o secretaria@fundeuis.com. Al validar la matricula usted será "
                    . "notificado via correo electrónico.";
            $this->get('session')->getFlashBag()->add(//Mensaje flash. Notificación de exito de la operación.
                    'notice', $mensaje
            );
            $this->EnviarCorreoElectronico($mensaje, 'FUNDEUIS - Pre Matricula', $estudiantenf->getUser()->getEmail());
        } else {
            $mensaje = "El curso que intenta matricular no existe o no se encuentra disponible. Intentelo de nuevo.";
            $this->get('session')->getFlashBag()->add(//Mensaje flash. Notificación de exito de la operación.
                    'error', $mensaje
            );
        }

        return $this->redirect($this->generateUrl('estudiantenf_educacion_estudiantenf_inicioPreinscripcion'));
    }

    /**
     * CORREO ELECTRONICO
     * 
     * @param type $mensaje
     * @param type $asunto
     * @param type $para
     */
    public function EnviarCorreoElectronico($mensaje, $asunto, $para) {

        $message = \Swift_Message::newInstance()
                ->setSubject($asunto)
                ->setFrom('webmaster@fundeuis.com')
                ->setTo($para)
                ->setBody(
                $this->renderView(
                        'FundeuisEducacionBundle:Estudiantenf:email.html.twig', array('mensaje' => $mensaje)
                ), 'text/html');
        $this->get('mailer')->send($message);
    }

}
