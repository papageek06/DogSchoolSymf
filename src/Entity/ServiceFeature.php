<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Service;

#[ORM\Entity]
class ServiceFeature
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(targetEntity: Service::class, inversedBy: 'features')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Service $service = null;

    public function getId(): ?int {
    return $this->id;
}

public function setId(?int $id): self {
    $this->id = $id;
    return $this;
}

public function getTitle(): ?string {
    return $this->title;
}

public function setTitle(?string $title): self {
    $this->title = $title;
    return $this;
}

public function getCreatedAt(): ?\DateTimeImmutable {
    return $this->createdAt;
}

public function setCreatedAt(?\DateTimeImmutable $createdAt): self {
    $this->createdAt = $createdAt;
    return $this;
}

public function getService(): ?Service {
    return $this->service;
}

public function setService(?Service $service): self {
    $this->service = $service;
    return $this;
}

}
