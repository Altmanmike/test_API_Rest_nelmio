<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\DeveloperRepository;

#[ORM\Entity(repositoryClass: DeveloperRepository::class)]
class Developer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;    
    
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;
    
    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private ?array $companies = null;
    
    #[ORM\Column]
    private ?int $experience = null;
    
    #[ORM\Column(options: ['default' => false])]
    private ?bool $isParticipant = null;    
    
    #[ORM\Column(options: ['default' => 'CURRENT_TIMESTAMP'])] 
    private ?\DateTimeImmutable $createdAt = null;
        
    #[ORM\Column(options: ['default' => 'CURRENT_TIMESTAMP'])] 
    private ?\DateTimeImmutable $updatedAt = null;

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

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCompanies(): ?array
    {
        return $this->companies;
    }

    public function setCompanies(?array $companies): static
    {
        $this->companies = $companies;

        return $this;
    }

    public function getExperience(): ?int
    {
        return $this->experience;
    }

    public function setExperience(int $experience): static
    {
        $this->experience = $experience;

        return $this;
    }

    public function isParticipant(): ?bool
    {
        return $this->isParticipant;
    }

    public function setIsParticipant(bool $isParticipant): static
    {
        $this->isParticipant = $isParticipant;

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
}