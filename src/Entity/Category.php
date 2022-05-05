<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=Service::class, mappedBy="category")
     */
    private $services;

    public function __construct()
    {
        $this->services = new ArrayCollection();
    }

    public function __toString() {
        return $this->description;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getServices(): Collection
    {
        return $this->Services;
    }

    public function addService(Service $service): self
    {
        if (!$this->Services->contains($service)) {
            $this->Services[] = $service;
            $service->setCategory($this);
        }

        return $this;
    }

    public function removeService(Service $service): self
    {
        if ($this->Services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getCategory() === $this) {
                $service->setCategory(null);
            }
        }

        return $this;
    }
}