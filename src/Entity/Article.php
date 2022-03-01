<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ArticleRepository;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * @Vich\Uploadable
 */
class Article implements TranslatableInterface
{
    use TranslatableTrait;

   /**
    * @var int
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue
    */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $poster = "";

    /**
     * @Vich\UploadableField(mapping="poster_file", fileNameProperty="poster")
     * @Assert\File(
     *     maxSize = "1M",
     *     mimeTypes = {"image/jpeg", "image/png", "image/webp"},
     * )
     * @var ?File
     */
    private ?File $posterFile = null;


    /**
     * @ORM\Column(type="datetime")
     *
     */
    private DateTime $createdAt;

    /**
     * @ORM\Column(type="integer")
     */
    private int $duration;

    /**
     * @ORM\ManyToOne(targetEntity=ArticleCategory::class, inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?ArticleCategory $category;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $updatedAt;


    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getCategory(): ?ArticleCategory
    {
        return $this->category;
    }

    public function setCategory(?ArticleCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->translate()->getTitle();
    }

    public function setTitle(string $title): self
    {
        $this->translate()->setTitle($title);

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->translate()->getSlug();
    }

    public function setSlug(?string $slug): self
    {
        $this->translate()->setSlug($slug);

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

    public function getAlt(): ?string
    {
        return $this->translate()->getAlt();
    }

    public function setAlt(string $alt): self
    {
        $this->translate()->setAlt($alt);

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->translate()->getSummary();
    }

    public function setSummary(string $summary): self
    {
        $this->translate()->setSummary($summary);

        return $this;
    }

    /**
     * @return File
     */
    public function getPosterFile(): ?File
    {
        return $this->posterFile;
    }

    /**
     * @param File|null $posterFile
     * @return Article
     */
    public function setPosterFile(?File $posterFile = null): self
    {
        $this->posterFile = $posterFile;
        if ($posterFile) {
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
