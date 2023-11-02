<?php

namespace App\Entity\EasyMedia;

use Adeliom\EasyMediaBundle\Entity\Media as BaseMedia;
use App\Entity\Data;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'easy_media__media')]
class Media extends BaseMedia
{
    #[ORM\ManyToOne(inversedBy: 'screenshot')]
    private ?Data $data = null;

    public function getData(): ?Data
    {
        return $this->data;
    }

    public function setData(?Data $data): static
    {
        $this->data = $data;

        return $this;
    }
}
