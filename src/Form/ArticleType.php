<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\ArticleCategory;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\File;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ArticleType extends AbstractType
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
                'category',
                EntityType::class,
                [
                    'choice_label' => 'name',
                    'label' => 'Catégorie',
                    'class' => ArticleCategory::class,
                ],
            )
            ->add(
                'summary',
                CKEditorType::class,
                [
                    'label' => 'Résumé de l\'article',
                    'config_name' => 'light',
                    'attr' => ['rows' => '4'],
                ],
            )
            ->add(
                'body',
                CKEditorType::class,
                [
                    'label' => 'Contenu de l\'article',
                    'config_name' => 'full',
                    'attr' => ['rows' => '10'],
                ],
            )
            ->add(
                'posterFile',
                VichFileType::class,
                [
                    'label' => 'Téléchargement de photos',
                    'required' => false,
                ]
            )
            ->add(
                'createdAt',
                DateTimeType::class,
                [
                    'label' => 'Date de création de l\'article',
                    'date_widget' => 'single_text'
                ],
            )
            ->add(
                'duration',
                NumberType::class,
                [
                    'label' => 'Temps de lecture (en minutes, ex: 10 pour 1O minutes)',
                ],
            )
            ->add(
                'alt',
                TextType::class,
                [
                    'label' => 'Texte alternatif à l\'image',
                ],
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
