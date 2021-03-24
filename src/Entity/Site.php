<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\SiteRepository;
use Doctrine\Common\Collections\Collection;

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
     * @ORM\OneToMany(targetEntity=Participant::class, mappedBy="site", orphanRemoval=true)
     */
    private $participants;

    /**
     * @ORM\OneToMany(targetEntity=Trip::class, mappedBy="site")
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

    /**
     * @return Collection|Participant[]
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(Participant $participant): self
    {
        if (! $this->participant->contains($participant)) {
            $this->participant[] = $participant;
            $participant->setSite($this);
        }

        return $this;
    }

    public function removeParticipant(Participant $participant): self
    {
        if ($this->participant->removeElement($participant)) {
            // set the owning side to null (unless already changed)
            if ($participant->getSite() === $this) {
                $participant->setSite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Trip[]
     */
    public function getTrips(): Collection
    {
        return $this->trips;
    }

    public function addTrip(Trip $trip): self
    {
        if (! $this->trips->contains($trip)) {
            $this->trips[] = $trip;
            $trip->setSite($this);
        }

        return $this;
    }

    public function removeTrip(Trip $trip): self
    {
        if ($this->trips->removeElement($trip)) {
            // set the owning side to null (unless already changed)
            if ($trip->getSite() === $this) {
                $trip->setSite(null);
            }
        }

        return $this;
    }
}
