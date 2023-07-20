<?php

namespace App\Entity;

use App\Repository\DomainRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DomainRepository::class)]
class Domain
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'domain', targetEntity: URL::class, orphanRemoval: true)]
    private Collection $urls;

    public function __construct()
    {
        $this->urls = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, URL>
     */
    public function getUrls(): Collection
    {
        return $this->urls;
    }

    public function addUrl(URL $url): static
    {
        if (!$this->urls->contains($url)) {
            $this->urls->add($url);
            $url->setDomain($this);
        }

        return $this;
    }

    public function removeUrl(URL $url): static
    {
        if ($this->urls->removeElement($url)) {
            // set the owning side to null (unless already changed)
            if ($url->getDomain() === $this) {
                $url->setDomain(null);
            }
        }

        return $this;
    }
}
