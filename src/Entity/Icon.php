<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Icon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $iconClass = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $category = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int {
    return $this->id;
}

public function setId(?int $id): self {
    $this->id = $id;
    return $this;
}

public function getIconClass(): ?string {
    return $this->iconClass;
}

public function setIconClass(?string $iconClass): self {
    $this->iconClass = $iconClass;
    return $this;
}

public function getName(): ?string {
    return $this->name;
}

public function setName(?string $name): self {
    $this->name = $name;
    return $this;
}

public function getCategory(): ?string {
    return $this->category;
}

public function setCategory(?string $category): self {
    $this->category = $category;
    return $this;
}

public function getCreatedAt(): ?\DateTimeImmutable {
    return $this->createdAt;
}

public function setCreatedAt(?\DateTimeImmutable $createdAt): self {
    $this->createdAt = $createdAt;
    return $this;
}

}
