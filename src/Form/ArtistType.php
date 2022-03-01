<?php

namespace App\Form;

use App\Entity\Artist;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ArtistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'photoFile',
                VichFileType::class,
                [
                    'label' => 'Téléchargement de photos',
                    'required' => false,
                ]
            )
            ->add('name', TextType::class, [
                'label' => "Nom de l'artiste"
            ])
            ->add('instruments', ChoiceType::class, [
                'choices' => [
                    'chant' => 'voice',
                    'violoncelle' => 'cello',
                    'violon' => 'violin',
                    'piano' => 'piano',
                    'alto' => 'viola',
                    'contrebasses' => 'bass',
                    'harpe' => 'harp',
                    'piccolo' => 'piccolo',
                    'flûte' => 'flute',
                    'hautbois' => 'oboe',
                    'cor anglais' => 'english horn',
                    'clarinette' => 'clarinet',
                    'clarinette basse' => 'bass clarinet',
                    'basson' => 'bassoon',
                    'contrebasson' => 'contrabassoon',
                    'cor' => ' french horn',
                    'trompette' => 'trumpet',
                    'trombone' => 'trombone',
                    'tuba' => 'tuba',
                    'percussion' => 'percussion',
                    'timbales' => 'timpani',
                    'chef d\'orchestre' => 'constructor',
                    'autre' => 'other',
                ],
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('nationality', TextType::class, [
                'label' => 'Nationalité',
            ])
            ->add('repository', TextType::class, [
                'label' => 'Répertoire musical'
            ])
            ->add('video', TextType::class, [
                'required' => false,
                'label' => 'lien vidéo',
            ])
            ->add('audio', TextType::class, [
                'required' => false,
                'label' => 'lien audio',
            ])
            ->add('body', CKEditorType::class, [
                'label' => 'Biographie de l\' artiste',
                'config_name' => 'full',
                'attr' => ['rows' => 10],
            ])
            ->add('alt', TextType::class, [
                'label' => 'Texte alternatif de l\' image.'
            ])
            ->add('slug')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artist::class,
        ]);
    }
}
