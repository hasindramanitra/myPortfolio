<?php

namespace App\Entity;

use App\Repository\ServicesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServicesRepository::class)]
class Services
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $serviceName = null;

    #[ORM\OneToMany(targetEntity: Technologie::class, mappedBy: 'services')]
    private Collection $technologie;

    public function __construct()
    {
        $this->technologie = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getServiceName(): ?string
    {
        return $this->serviceName;
    }

    public function setServiceName(string $serviceName): static
    {
        $this->serviceName = $serviceName;

        return $this;
    }

    /**
     * @return Collection<int, Technologie>
     */
    public function getTechnologie(): Collection
    {
        return $this->technologie;
    }

    public function addTechnologie(Technologie $technologie): static
    {
        if (!$this->technologie->contains($technologie)) {
            $this->technologie->add($technologie);
            $technologie->setServices($this);
        }

        return $this;
    }

    public function removeTechnologie(Technologie $technologie): static
    {
        if ($this->technologie->removeElement($technologie)) {
            // set the owning side to null (unless already changed)
            if ($technologie->getServices() === $this) {
                $technologie->setServices(null);
            }
        }

        return $this;
    }
}
