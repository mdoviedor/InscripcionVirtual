<?php

namespace Fundeuis\EducacionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ComunidadController extends Controller {

    public function indexAction() {

        if ($this->get('security.context')->isGranted('ROLE_ESTUDIANTENF')) {//Existe una sesion con el usuario Rol ADMINISTRADOR;            
            return$this->redirect($this->generateUrl('estudiantenf_educacion_estudiantenf_inicioPreinscripcion'));
        } elseif ($this->get('security.context')->isGranted('ROLE_ADMINISTRADOR')) {
            return $this->redirect($this->generateUrl('administrador_educacion_estudiantenf'));
        } elseif ($this->get('security.context')->isGranted('ROLE_SUPERADMINISTRADOR')) {
            return$this->redirect($this->generateUrl('administrador_educacion_estudiantenf'));
        } else {
            //return $this->redirect($this->generateUrl('fos_user_security_login'));      
            return $this->render('FundeuisEducacionBundle:Comunidad:index.html.twig', array());
        }
    }

}
