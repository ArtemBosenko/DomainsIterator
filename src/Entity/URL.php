<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\URLRepository;
use Doctrine\ORM\PersistentCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

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

    #[ORM\OneToMany(mappedBy: 'url', targetEntity: Data::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $data;

    public function __construct()
    {
        $this->data = new ArrayCollection();
    }

    public function getValues()
    {
        return [
            'id' => $this->getId(), 
            'address' => $this->getAddress(), 
            'domain_id' => $this->getDomain()->getId(), 
            'data' => $this->getData()
        ];
    }

    public function __toString()
    {
        return $this->address;
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

    public function getData(): array
    {
        $data = $this->data;
        $return = [];
        if(!empty($data) && $data instanceof PersistentCollection ){
            $data = $data->getValues();
            foreach ($data as $key => $data) {
                $return[$key] = $data->getValues();
            }
        }
        return $return;
    }

    public function addData(Data $data): static
    {
        if (!$this->data->contains($data)) {
            $this->data->add($data);
            $data->setUrl($this);
        }

        return $this;
    }

    public function removeData(Data $data): static
    {
        if ($this->data->removeElement($data)) {
            // set the owning side to null (unless already changed)
            if ($data->getUrl() === $this) {
                $data->setUrl(null);
            }
        }

        return $this;
    }
}
