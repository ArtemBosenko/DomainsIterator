<?php

namespace App\Entity;

use App\Repository\DataRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DataRepository::class)]
class Data
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'data')]
    #[ORM\JoinColumn(nullable: false)]
    private ?URL $url = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString()
    {
        return 'Date: ' . $this->getDate()->format('d-m-Y H:i:s') . ' / Status: ' . $this->getStatus();
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getUrl(): ?URL
    {
        return $this->url;
    }

    public function setUrl(?URL $url): static
    {
        $this->url = $url;

        return $this;
    }
}
