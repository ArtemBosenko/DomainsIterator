<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\DomainRepository;
use Doctrine\ORM\PersistentCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: DomainRepository::class)]
class Domain
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'domain', targetEntity: URL::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $urls;

    public function __construct()
    {
        $this->urls = new ArrayCollection();
    }

    public function getValues()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'urls' => $this->getUrls(),
        ];
    }

    public function __toString()
    {
        return $this->getName();
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


    public function getUrls()
    {
        $urls = $this->urls;
        $return_data = [];
        if(!empty($urls) && $urls instanceof PersistentCollection ){
            $urls = $urls->getValues();
            foreach ($urls as $key => $url) {
                $return_data[$key] = $url->getValues();
            }
        }
        return $return_data;
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
