<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'title',
                TextType::class,
                [
                    'label' => 'Titre',
                ],
            )
            ->add(
                'text',
                TextareaType::class,
                [
                    'label' => 'Description de l\'évenement',
                    'attr' => ['rows' => '10'],
                ],
            )
            ->add(
                'poster',
                TextType::class,
                [
                    'label' => 'Photo de l\'évenement',
                ],
            )
            ->add(
                'video',
                UrlType::class,
                [
                    'label' => 'Video de l\'évenement',
                ],
            )
            ->add(
                'date',
                DateType::class,
                [
                    'label' => 'Horaire de l\'évenement',
                ],
            )
            ->add(
                'duration',
                NumberType::class,
                [
                    'label' => 'Durée de l\'évenement',
                ]
            )
            ->add(
                'alt',
                TextType::class,
                [
                    'label' => 'Texte alternatif à l\'image',
                ],
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
