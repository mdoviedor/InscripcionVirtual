<?php

namespace Fundeuis\EducacionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsuarioCursoType extends AbstractType {

    protected $cursos = array();

    public function __construct(array $cursos) {
        foreach ($cursos as $value) {
            $this->cursos[$value->getId()] = $value->getNombrecurso()->getNombre() . ' ' . date_format($value->getFechainicio(), 'Y-m-d');
        };
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('estado', null, array(
                    'required' => true,
                    'label' => 'Marque para matricular al estudiante al curso',
                    'attr' => array('class' => 'form-control')
                ))
                ->add('curso', 'choice', array(
                    'choices' => $this->cursos,
                    'mapped' => false,
                    'label' => '* Curso',
                    'required' => true,
                    'attr' => array('class' => 'form-control')
                ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Fundeuis\EducacionBundle\Entity\UsuarioCurso'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'fundeuis_educacionbundle_usuariocurso';
    }

}
