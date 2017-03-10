<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Alumno;
use AppBundle\Entity\Grupo;
use AppBundle\Entity\Profesor;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints\Length;

class ProfesorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', null, [
                'label' => 'form.nombre'
            ])
            ->add('apellidos', null, [
                'label' => 'form.apellidos'
            ])
            ->add('dni', null, [
                'label' => 'form.dni'
            ])
            ->add('administrador', null, [
                'label' => 'form.administrador',
                'disabled' => ($options['es_admin'] === false)
            ]);
        if (false === $options['es_admin']) {
            $builder
                ->add('antigua', PasswordType::class, [
                    'label' => 'form.clave_antigua',
                    'mapped' => false,
                    'constrains' => [
                        new UserPassword(), //solo valdrá  si metemos la contraseña del usuario
                        new Length(['min' => 4])
                    ]
                ])
                ->add('nueva', RepeatedType::class, [
                    'mapped' => false,
                    'type' => PasswordType::class,
                    'fist_options' => [
                        'label' => 'form.clave_neuva'
                    ],
                    'second_options' => [
                        'label' => 'form.clave_nueva_repetir'
                    ]
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profesor::class,
            'translation_domain' => 'profesor',
            'es_admin' => false
        ]);
    }
}
