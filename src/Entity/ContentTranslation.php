<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ContentTranslationRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Knp\DoctrineBehaviors\Model\Translatable\TranslationTrait;
use Knp\DoctrineBehaviors\Contract\Entity\TranslationInterface;

/**
 * @ORM\Entity(repositoryClass=ContentTranslationRepository::class)
 */
class ContentTranslation implements TranslationInterface
{
  use TranslationTrait;

  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  private int $id;

  /**
   * @ORM\Column(type="string", length=255)
   * @Assert\NotBlank(message="Merci de remplir ce champ")
   */
  private string $title = "";

  /**
   * @ORM\Column(type="text")
   */
  private string $body = "";

  /**
   * @ORM\Column(type="string", length=255, nullable=true)
   */
  private ?string $alt = "";

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getTitle(): ?string
  {
    return $this->title;
  }

  public function setTitle(string $title): self
  {
    $this->title = $title;

    return $this;
  }

  public function getBody(): ?string
  {
    return $this->body;
  }

  public function setBody(string $body): self
  {
    $this->body = $body;

    return $this;
  }

  public function getAlt(): ?string
  {
    return $this->alt;
  }

  public function setAlt(?string $alt): self
  {
    $this->alt = $alt;

    return $this;
  }
}
