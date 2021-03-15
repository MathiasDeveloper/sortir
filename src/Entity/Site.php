<?php

namespace App\Entity;

use App\Repository\SiteRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SiteRepository::class)
 */
class Site
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Participant::class, mappedBy="site")
     * @ORM\JoinColumn(nullable=false)
     */
    private $participant;

    /**
     * @ORM\OneToMany(targetEntity=Trip::class, mappedBy="place")
     */
    private $trips;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getParticipant(): ?Participant
    {
        return $this->participant;
    }

    public function setParticipant(?Participant $participant): self
    {
        $this->participant = $participant;

        return $this;
    }

    /**
     * @return Collection|Trip[]
     */
    public function getTrips(): Collection
    {
        return $this->trips;
    }

    public function addTrips(Trip $trips): self
    {
        if (!$this->trips->contains($trips)) {
            $this->trips[] = $trips;
            $trips->setSite($this);
        }

        return $this;
    }

    public function removeTrips(Trip $trips): self
    {
        if ($this->trips->removeElement($trips)) {
            // set the owning side to null (unless already changed)
            if ($trips->getSite() === $this) {
                $trips->setSite(null);
            }
        }

        return $this;
    }
}
