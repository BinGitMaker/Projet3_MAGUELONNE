<?php

namespace App\Form;

use App\Entity\Content;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ContentType extends AbstractType
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
        'body',
        CKEditorType::class,
        [
          'label' => 'Contenu de la page',
          'config_name' => 'full',
          'attr' => ['rows' => '30'],
        ],
      )
      ->add(
        'poster',
        TextType::class,
        [
          'label' => 'Image d\'en-tête',
          'help' => 'Champ facultatif',
          'required' => false
        ],
      )
      ->add(
        'alt',
        TextType::class,
        [
          'label' => 'Texte Alternatif à l\'image',
          'required' => false
        ],
      );
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Content::class,
    ]);
  }
}
