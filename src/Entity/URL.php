<?php

namespace App\Entity;

use App\Repository\URLRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: URLRepository::class)]
class URL
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\ManyToOne(inversedBy: 'urls')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Domain $domain = null;

    #[ORM\OneToMany(mappedBy: 'url', targetEntity: Data::class, orphanRemoval: true)]
    private Collection $url_data;

    public function __construct()
    {
        $this->url_data = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getDomain(): ?Domain
    {
        return $this->domain;
    }

    public function setDomain(?Domain $domain): static
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * @return Collection<int, Data>
     */
    public function getUrlData(): Collection
    {
        return $this->url_data;
    }

    public function addUrlData(Data $urlData): static
    {
        if (!$this->url_data->contains($urlData)) {
            $this->url_data->add($urlData);
            $urlData->setUrl($this);
        }

        return $this;
    }

    public function removeUrlData(Data $urlData): static
    {
        if ($this->url_data->removeElement($urlData)) {
            // set the owning side to null (unless already changed)
            if ($urlData->getUrl() === $this) {
                $urlData->setUrl(null);
            }
        }

        return $this;
    }
}
