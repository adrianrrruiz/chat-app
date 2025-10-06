<?php

namespace App\Form;

use App\Entity\Chat;
use App\Entity\Mensaje;
use App\Entity\Persona;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MensajeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('contenido')
            ->add('fecha', null, [
                'widget' => 'single_text',
            ])
            ->add('persona', EntityType::class, [
                'class' => Persona::class,
                'choice_label' => 'id',
            ])
            ->add('chat', EntityType::class, [
                'class' => Chat::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mensaje::class,
        ]);
    }
}
