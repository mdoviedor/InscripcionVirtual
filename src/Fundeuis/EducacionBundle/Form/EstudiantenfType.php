<?php

namespace Fundeuis\EducacionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EstudiantenfType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    protected $cien = array();
    protected $correoElectronico = null;
    protected $ciudad = null;
    protected $departamento = null;

    public function __construct($correoElectronico, $ciudad, $departamento) {
        for ($i = 10; $i <= 60; $i++) {
            $this->cien[$i] = $i;
        }
        $this->correoElectronico = $correoElectronico;
        $this->ciudad = $ciudad;
        $this->departamento = $departamento;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                ->add('documentoidentidad', 'repeated', array(
                    'type' => 'text',
                    'invalid_message' => 'Los campos deben coincidir.',
                    'required' => true,
                    'first_options' => array(
                        'label' => '* Identificación:',
                        'attr' => array('class' => 'form-control')),
                    'second_options' => array(
                        'label' => '* Repita Identificación:',
                        'attr' => array('class' => 'form-control'))))
                ->add('correoElectronico', 'repeated', array(
                    'mapped' => false,
                    'type' => 'email',
                    'invalid_message' => 'Los campos deben coincidir.',
                    'required' => true,
                    'first_options' => array(
                        'label' => '* Correo electrónico:',
                        'attr' => array('class' => 'form-control', 'value' => $this->correoElectronico)),
                    'second_options' => array(
                        'label' => '* Repita Correo electrónico:',
                        'attr' => array('class' => 'form-control', 'value' => $this->correoElectronico))))
                ->add('nombres', 'text', array(
                    'label' => '* Nombres:',
                    'attr' => array('class' => 'form-control')))
                ->add('apellidos', 'text', array(
                    'label' => '* Apellidos:',
                    'attr' => array('class' => 'form-control')))
                ->add('edad', 'choice', array(
                    'label' => '* Edad:',
                    'choices' => $this->cien,
                    'attr' => array('class' => 'form-control')))
                ->add('telefono', 'text', array(
                    'required' => false,
                    'label' => 'Fijo:',
                    'attr' => array('class' => 'form-control')))
                ->add('celular', 'text', array(
                    'required' => false,
                    'label' => 'Celular:',
                    'attr' => array('class' => 'form-control')))
                ->add('estrato', 'choice', array(
                    'label' => '* Estrato:',
                    'choices' => array(
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                        '6' => '6',
                    ),
                    'attr' => array('class' => 'form-control')))
                ->add('universidad', 'text', array(
                    'label' => '* Universidad a la que aspira:',
                    'attr' => array('class' => 'form-control')))
                ->add('colegio', 'text', array(
                    'label' => '* Colegio del que egreso:',
                    'attr' => array('class' => 'form-control')))
                ->add('nombresacudiente', 'text', array(
                    'label' => '* Nombres del acudiente:',
                    'attr' => array('class' => 'form-control')))
                ->add('apellidosacudiente', 'text', array(
                    'label' => '* Apellidos del acudiente:',
                    'attr' => array('class' => 'form-control')))
                ->add('telefonoacudiente', 'text', array(
                    'label' => '* Teléfono del Acudiente (Fijo o Celular):',
                    'attr' => array('class' => 'form-control')))
                //->add('user')
                //->add('rol')
                //->add('autor')
                ->add('programaacademico', null, array(
                    'required' => true,
                    'label' => '* Programa académico:',
                    'attr' => array('class' => 'form-control')))
                ->add('tipodocumentoidentidad', null, array(
                    'required' => true,
                    'label' => '* Tipo de documento de identidad:',
                    'attr' => array('class' => 'form-control')))
                ->add('departamento', 'entity', array(
                    'required' => true,
                    'mapped' => false,
                    'empty_value' => 'Seleccionar',
                    'class' => 'FundeuisEducacionBundle:Departamento',
                    'property' => 'nombre',
                    'label' => '* Departamento:' . $this->departamento,
                    'attr' => array('class' => 'form-control')))
                ->add('ciudad', 'text', array(
                    'mapped' => false,
                    'label' => '* Ciudad:',
                    'attr' => array('class' => 'form-control', 'value' => $this->ciudad)))
                ->add('conocimiento', null, array(
                    'required' => true,
                    'label' => '* ¿Cómo conoció Fundeuis?:',
                    'attr' => array('class' => 'form-control')))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Fundeuis\EducacionBundle\Entity\Estudiantenf'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'fundeuis_educacionbundle_estudiantenf';
    }

}
