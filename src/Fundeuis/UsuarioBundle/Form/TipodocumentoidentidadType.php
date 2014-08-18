<?php

namespace Fundeuis\UsuarioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TipodocumentoidentidadType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fundeuis\UsuarioBundle\Entity\Tipodocumentoidentidad'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fundeuis_usuariobundle_tipodocumentoidentidad';
    }
}
