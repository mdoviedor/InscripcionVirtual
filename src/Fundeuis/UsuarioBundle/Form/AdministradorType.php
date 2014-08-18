<?php

namespace Fundeuis\UsuarioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdministradorType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
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
                        'attr' => array('class' => 'form-control')),
                    'second_options' => array(
                        'label' => '* Repita Correo electrónico:',
                        'attr' => array('class' => 'form-control'))))
                ->add('nombres', 'text', array(
                    'label' => '* Nombres:',
                    'attr' => array('class' => 'form-control')))
                ->add('apellidos', 'text', array(
                    'label' => '* Apellidos:',
                    'attr' => array('class' => 'form-control'))
                )
                //->add('fecharegistro',)
                ->add('tipodocumentoidentidad', null, array(
                    'label' => '* Tipo de documento de Identidad:',
                    'attr' => array('class' => 'form-control'))
                )
                //->add('user')
                ->add('rol', null,  array(
                    'label' => '* Rol:',
                    'attr' => array('class' => 'form-control')
                ))
        //->add('autor')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Fundeuis\UsuarioBundle\Entity\Administrador'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'fundeuis_usuariobundle_administrador';
    }

}
