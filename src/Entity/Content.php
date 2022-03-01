<?php

namespace App\Entity;

use App\Repository\ContentRepository;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ContentRepository::class)
 */
class Content implements TranslatableInterface
{
  use TranslatableTrait;

  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  private int $id;

  /**
   * @ORM\Column(type="string", length=255, nullable=true)
   */
  private ?string $poster;

  /**
   * @ORM\Column(type="string", length=255, nullable=true)
   */
  private ?string $slug = "";

  /**
   * @ORM\Column(type="string", length=255, nullable=true)
   */
  private ?string $identifier;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getTitle(): ?string
  {
    return $this->translate()->getTitle();
  }

  public function setTitle(?string $title): self
  {
    $this->translate()->setTitle($title);

    return $this;
  }

  public function getSlug(): ?string
  {
    return $this->slug;
  }

  public function setSlug(?string $slug): self
  {
    $this->slug = $slug;

    return $this;
  }

  public function getBody(): ?string
  {
    return $this->translate()->getBody();
  }

  public function setBody(string $body): self
  {
    $this->translate()->setBody($body);

    return $this;
  }

  public function getPoster(): ?string
  {
    return $this->poster;
  }

  public function setPoster(?string $poster): self
  {
    $this->poster = $poster;

    return $this;
  }

  public function getAlt(): ?string
  {
    return $this->translate()->getAlt();
  }

  public function setAlt(?string $alt): self
  {
    $this->translate()->setAlt($alt);

    return $this;
  }

  public function getIdentifier(): ?string
  {
    return $this->identifier;
  }

  public function setIdentifier(?string $identifier): self
  {
    $this->identifier = $identifier;

    return $this;
  }

  public function __toString()
  {
    return $this->title;
  }
}
