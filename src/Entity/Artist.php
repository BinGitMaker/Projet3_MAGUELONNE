<?php

namespace App\Entity;

use DateTime;
use App\Repository\ArtistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ArtistRepository::class)
 * @Vich\Uploadable
 */
class Artist implements TranslatableInterface
{
    use TranslatableTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=80)
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Assert\Length(
     *     min = 2,
     *     max = 80,
     *     minMessage = "Le nom doit faire au minimum 2 caractéres.",
     *     maxMessage = "Le nom ne peut pas être plus long que 80 caractéres"
     *     )
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Assert\Length (
     *     max = 255,
     *     maxMessage = "La longueur du texte est limité à 255 caractéres."
     * )
     */
    private ?string $photo = "";

    /**
     * @Vich\UploadableField(mapping="poster_file", fileNameProperty="photo")
     * @Assert\File(
     *     maxSize = "1M",
     *     mimeTypes = {"image/jpeg", "image/png", "image/webp"},
     * )
     * @var ?File
     */
    private ?file $photoFile = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Assert\Length (
     *     max = 255,
     *     maxMessage = "La longueur du texte est limité à 255 caractéres."
     * )
     */
    private ?string $video;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Assert\Length (
     *     max = 255,
     *     maxMessage = "La longueur du texte est limité à 255 caractéres."
     * )
     */
    private ?string $audio;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Assert\Length (
     *     max = 255,
     *     maxMessage = "La longueur du texte est limité à 255 caractéres."
     * )
     */
    private ?string $slug = '';

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     */
    private DateTime $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $updatedAt;

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @ORM\OneToMany(targetEntity=Company::class, mappedBy="artist")
     */
    private Collection $company;

    /**
     * @ORM\OneToMany(targetEntity=Reward::class, mappedBy="artist")
     */
    private Collection $reward;

    /**
     * @ORM\OneToMany(targetEntity=Study::class, mappedBy="artist")
     */
    private Collection $study;

    /**
     * @ORM\Column(type="json", nullable=true)
     *
     */
    private ?array $instruments = [];

    public function __construct()
    {
        $this->company = new ArrayCollection();
        $this->reward = new ArrayCollection();
        $this->study = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getAudio(): ?string
    {
        return $this->audio;
    }

    public function setAudio(?string $audio): self
    {
        $this->audio = $audio;

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

    /**
     * @return File
     */
    public function getPhotoFile(): ?File
    {
        return $this->photoFile;
    }

    /**
     * @param File|null $photoFile
     * @return Artist
     */
    public function setPhotoFile(?File $photoFile = null): self
    {
        $this->photoFile = $photoFile;
        if ($photoFile) {
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }

    /**
     * @return Collection|Company[]
     */
    public function getCompany(): Collection
    {
        return $this->company;
    }

    public function addCompany(Company $company): self
    {
        if (!$this->company->contains($company)) {
            $this->company[] = $company;
            $company->setArtist($this);
        }

        return $this;
    }

    public function removeCompany(Company $company): self
    {
        if ($this->company->removeElement($company)) {
            // set the owning side to null (unless already changed)
            if ($company->getArtist() === $this) {
                $company->setArtist(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Reward[]
     */
    public function getReward(): Collection
    {
        return $this->reward;
    }

    public function addReward(Reward $reward): self
    {
        if (!$this->reward->contains($reward)) {
            $this->reward[] = $reward;
            $reward->setArtist($this);
        }

        return $this;
    }

    public function removeReward(Reward $reward): self
    {
        if ($this->reward->removeElement($reward)) {
            // set the owning side to null (unless already changed)
            if ($reward->getArtist() === $this) {
                $reward->setArtist(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Study[]
     */
    public function getStudy(): Collection
    {
        return $this->study;
    }

    public function addStudy(Study $study): self
    {
        if (!$this->study->contains($study)) {
            $this->study[] = $study;
            $study->setArtist($this);
        }

        return $this;
    }

    public function removeStudy(Study $study): self
    {
        if ($this->study->removeElement($study)) {
            // set the owning side to null (unless already changed)
            if ($study->getArtist() === $this) {
                $study->setArtist(null);
            }
        }

        return $this;
    }

    public function getRepository(): ?string
    {
        return $this->translate()->getRepository();
    }

    public function setRepository(string $repository): self
    {
        $this->translate()->setRepository($repository);

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->translate()->getNationality();
    }

    public function setNationality(string $nationality): self
    {
        $this->translate()->setNationality($nationality);

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

    public function getInstruments(): ?array
    {
        return $this->instruments;
    }

    public function setInstruments(?array $instruments): self
    {
        $this->instruments = $instruments;

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
