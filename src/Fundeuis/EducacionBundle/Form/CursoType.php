<?php

namespace Fundeuis\EducacionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CursoType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('fechainicio', 'date', array(
                    'label' => '* Fecha de Inicio:',
                    'attr' => array('class' => 'form-control')))
                ->add('fechafin', 'date', array(
                    'label' => '* Fecha de Finalización:',
                    'attr' => array('class' => 'form-control')))
                ->add('duracion', 'text', array(
                    'label' => '* Duración en horas:',
                    'attr' => array('class' => 'form-control')))
                ->add('horainiciomanana', 'time', array(
                    'required' => false,
                    'label' => 'Hora de inicio en la mañana:',
                    'attr' => array('class' => 'form-control')))
                ->add('horafinmanana', 'time', array(
                    'required'=>false,
                    'label' => 'Hora de finalización en la mañana::',
                    'attr' => array('class' => 'form-control')))
                ->add('horainiciotarde', 'time', array(
                    'required'=>false,
                    'label' => 'Hora de inicio en la tarde:',
                    'attr' => array('class' => 'form-control')))
                ->add('horafintarde', 'time', array(
                    'required'=>false,
                    'label' => 'Hora de finalización en la tarde:',
                    'attr' => array('class' => 'form-control')))
                ->add('intensidadhoraria', 'text', array(
                    'label' => '* Intensidad horaria:',
                    'attr' => array('class' => 'form-control')))
                ->add('descripcion', 'textarea', array(
                    'label' => '* Descripción:',
                    'attr' => array('class' => 'form-control')))
                //->add('autor')
                ->add('nombrecurso', null, array(
                    'label' => '* Nombre del curso:',
                    'attr' => array('class' => 'form-control')))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Fundeuis\EducacionBundle\Entity\Curso'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'fundeuis_educacionbundle_curso';
    }

}
