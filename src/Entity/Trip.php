<?php

namespace App\Entity;

use App\Enum\StateTypeEnum;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TripRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=TripRepository::class)
 */
class Trip
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
     * @ORM\Column(type="datetime")
     */
    private $begin_date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $duration;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $end_date;

    /**
     * @ORM\Column(type="integer")
     */
    private $max_subscriptions;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Participant::class, inversedBy="subscriptions")
     */
    private $subscriptions;

    /**
     * @ORM\ManyToOne(targetEntity=Place::class, inversedBy="trips")
     */
    private $place;

    /**
     * @ORM\ManyToOne(targetEntity=Participant::class, inversedBy="trips")
     */
    private $organisor;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $state;

    /**
     * @ORM\ManyToOne(targetEntity=Site::class, inversedBy="participants")
     */
    private $site;

    public function __construct()
    {
        $this->subscriptions = new ArrayCollection();
    }

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

    public function getBeginDate(): ?\DateTimeInterface
    {
        return $this->begin_date;
    }

    public function setBeginDate(\DateTimeInterface $begin_date): self
    {
        $this->begin_date = $begin_date;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(?\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getMaxSubscriptions(): ?int
    {
        return $this->max_subscriptions;
    }

    public function setMaxSubscriptions(int $max_subscriptions): self
    {
        $this->max_subscriptions = $max_subscriptions;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Participant[]
     */
    public function getSubscriptions(): Collection
    {
        return $this->subscriptions;
    }

    public function addSubscription(Participant $subscription): self
    {
        if (! $this->subscriptions->contains($subscription)) {
            $this->subscriptions[] = $subscription;
        }

        return $this;
    }

    public function removeSubscription(Participant $subscription): self
    {
        $this->subscriptions->removeElement($subscription);

        return $this;
    }

    public function getPlace(): ?Place
    {
        return $this->place;
    }

    public function setPlace(?Place $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getOrganisor(): ?Participant
    {
        return $this->organisor;
    }

    public function setOrganisor(?Participant $organisor): self
    {
        $this->organisor = $organisor;

        return $this;
    }

    public function getState(): ?string
    {
        return StateTypeEnum::getTypeName($this->state);
    }

    public function setState(string $state): self
    {
        if (! in_array($state, StateTypeEnum::getAvailableTypes())) {
            throw new \InvalidArgumentException('Invalid type');
        }

        $this->state = $state;

        return $this;
    }

    public function getSite(): ?Site
    {
        return $this->site;
    }

    public function setSite(?Site $site): self
    {
        $this->site = $site;

        return $this;
    }
}
