<?php

namespace App\Entity;

use App\Repository\ServicesRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: ServicesRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: 'text')]
    private ?string $description = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?float $price = null;

    #[ORM\Column(length: 50)]
    private ?string $duration = null;

    #[ORM\ManyToOne(targetEntity: Icon::class)]
    private ?Icon $icon = null;

    #[ORM\Column(type: 'boolean')]
    private bool $isFeatured = false;

    #[ORM\Column(length: 50, options: ['default' => 'bg-gray-50'])]
    private ?string $backgroundColor = 'bg-gray-50';

    #[ORM\Column(length: 50, options: ['default' => 'text-gray-600'])]
    private ?string $textColor = 'text-gray-600';

    #[ORM\Column(length: 50, options: ['default' => 'bg-primary-600'])]
    private ?string $buttonColor = 'bg-primary-600';

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: ServiceFeature::class, cascade: ['persist', 'remove'])]
    private Collection $features;

    public function __construct()
    {
        $this->features = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;
        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): static
    {
        $this->duration = $duration;
        return $this;
    }

    public function getIcon(): ?Icon
    {
        return $this->icon;
    }

    public function setIcon(?Icon $icon): static
    {
        $this->icon = $icon;
        return $this;
    }

    public function isFeatured(): bool
    {
        return $this->isFeatured;
    }

    public function setIsFeatured(bool $isFeatured): static
    {
        $this->isFeatured = $isFeatured;
        return $this;
    }

    public function getBackgroundColor(): ?string
    {
        return $this->backgroundColor;
    }

    public function setBackgroundColor(string $backgroundColor): static
    {
        $this->backgroundColor = $backgroundColor;
        return $this;
    }

    public function getTextColor(): ?string
    {
        return $this->textColor;
    }

    public function setTextColor(string $textColor): static
    {
        $this->textColor = $textColor;
        return $this;
    }

    public function getButtonColor(): ?string
    {
        return $this->buttonColor;
    }

    public function setButtonColor(string $buttonColor): static
    {
        $this->buttonColor = $buttonColor;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getFeatures(): Collection
    {
        return $this->features;
    }

    public function addFeature(ServiceFeature $feature): static
    {
        if (!$this->features->contains($feature)) {
            $this->features->add($feature);
            $feature->setService($this);
        }
        return $this;
    }

    public function removeFeature(ServiceFeature $feature): static
    {
        if ($this->features->removeElement($feature)) {
            if ($feature->getService() === $this) {
                $feature->setService(null);
            }
        }
        return $this;
    }
}
