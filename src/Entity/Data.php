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

    #[ORM\Column(options: ['default' => false])]
    private ?bool $has_error = false;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $error_description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $screenshot = null;


    final public function getValues(): array
    {
        return [
            'id' => $this->getId(),
            'status' => $this->getStatus(),
            'date' => $this->getDate(),
            'url_id' => $this->getUrl()->getId(),
            'has_error' => $this->isHasError(),
            'error_description' => $this->getErrorDescription(),
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString()
    {
        $string = 'Date of parsing: '.$this->getDate()->format('d-m-Y H:i:s');
        $string .= ' / Status: '.$this->getStatus();
        if ($this->isHasError()) {
            $string .= ' / Has error';
            if ($this->getErrorDescription()) {
                $string .= ' / Error description: '.$this->getErrorDescription();
            }
        }

        return $string;
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

    public function isHasError(): ?bool
    {
        return $this->has_error;
    }

    public function setHasError(bool $has_error): static
    {
        $this->has_error = $has_error;

        return $this;
    }

    public function getErrorDescription(): ?string
    {
        return $this->error_description;
    }

    public function setErrorDescription(?string $error_description): static
    {
        $this->error_description = $error_description;

        return $this;
    }

    public function getScreenshot(): ?string
    {
        return $this->screenshot;
    }

    public function setScreenshot(?string $screenshot): static
    {
        $this->screenshot = $screenshot;

        return $this;
    }
}
