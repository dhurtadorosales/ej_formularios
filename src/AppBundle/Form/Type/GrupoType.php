<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Grupo;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GrupoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descripcion', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
                'label' => 'Descripción del aula'
            ])
            ->add('aula', \Symfony\Component\Form\Extension\Core\Type\TextType::class) //Para que no me salga el texto numérico
            ->add('planta', IntegerType::class, [
                'required' => false
            ])
            ->add('tutor', null, [
                'placeholder' => '[No hay ninguno seleccionado]',
                'expanded' => false
            ]);
            //Podemos poner aquí el botón submit aunque no es lo adecuado
            /*->add('enviar', SubmitType::class, [
                'label' => 'Guardar los cambios',
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ]);*/

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Grupo::class
        ]);
    }
}
