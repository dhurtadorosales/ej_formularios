<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Alumno;
use AppBundle\Entity\Grupo;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AlumnoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', null)
            ->add('apellidos', null)
            ->add('grupo', null)
            ->add('fechaNacimiento', null, [
                'widget' => 'single_text',   //'choice'
                //'format' => 'dd-MM-yyyy'
            ])
            ->add('Observaciones');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Alumno::class
        ]);
    }
}
