<?php

namespace Fundeuis\EducacionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ComunidadController extends Controller {

    public function indexAction() {

        if ($this->get('security.context')->isGranted('ROLE_SUPERADMINISTRADOR')) {//Existe una sesion con el usuario Rol ADMINISTRADOR
// return $this->redirect($this->generateUrl('gs_proyectos_vistaherramientas'));            
            return $this->redirect($this->generateUrl('administrador_educacion_estudiantenf'));
        } elseif ($this->get('security.context')->isGranted('ROLE_ESTUDIANTENF')) {
            return$this->redirect($this->generateUrl('estudiantenf_educacion_estudiantenf_inicioPreinscripcion'));
        } else {
            return $this->render('FundeuisEducacionBundle:Comunidad:index.html.twig');
        }
       
    }

}
