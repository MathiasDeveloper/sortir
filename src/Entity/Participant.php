<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ParticipantRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=ParticipantRepository::class)
 */
class Participant implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private string $username;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $password;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $registrationDate;

    /**
     * @ORM\Column(type="json")
     */
    private iterable $roles;

    /**
     * @ORM\Column(type="boolean")
     */
    private $administrator;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\ManyToOne(targetEntity=Site::class, inversedBy="participants")
     */
    private $site;

    /**
     * @ORM\ManyToMany(targetEntity=Trip::class, mappedBy="subscriptions")
     */
    private $subscriptions;

    /**
     * @ORM\OneToMany(targetEntity=Trip::class, mappedBy="organisor")
     */
    private $trips;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $photoUrl;

    public function __construct()
    {
        $this->subscriptions = new ArrayCollection();
        $this->trips = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(\DateTimeInterface $registrationDate): self
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getSalt()
    {
    }

    public function eraseCredentials()
    {
        // $this->password = '';
    }

    public function getAdministrator(): ?bool
    {
        return $this->administrator;
    }

    public function setAdministrator(bool $administrator): self
    {
        $this->administrator = $administrator;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

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

    /**
     * @return Collection|Trip[]
     */
    public function getSubscriptions(): Collection
    {
        return $this->subscriptions;
    }

    public function addSubscription(Trip $subscription): self
    {
        if (! $this->subscriptions->contains($subscription)) {
            $this->subscriptions[] = $subscription;
            $subscription->addSubscription($this);
        }

        return $this;
    }

    public function removeSubscription(Trip $subscription): self
    {
        if ($this->subscriptions->removeElement($subscription)) {
            $subscription->removeSubscription($this);
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
            $trip->setOrganisor($this);
        }

        return $this;
    }

    public function removeTrip(Trip $trip): self
    {
        if ($this->trips->removeElement($trip)) {
            // set the owning side to null (unless already changed)
            if ($trip->getOrganisor() === $this) {
                $trip->setOrganisor(null);
            }
        }

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * For authent.
     *
     * @return array
     */
    public function getRoles(): array
    {
        $roles[] = 'ROLE_USER';
        if ($this->getAdministrator()) {
            $roles[] = 'ROLE_ADMIN';
        }

        return array_unique($roles);
    }

    public function getCurrentRoles()
    {
        return $this->roles;
    }

    /**
     * @param array|iterable $roles
     */
    public function setRoles(iterable $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * Get the value of photoUrl.
     */
    public function getPhotoUrl()
    {
        if (filter_var($this->photoUrl, FILTER_VALIDATE_URL)) {
            return $this->photoUrl;
        }

        if (null !== $this->photoUrl) {
            return "/uploads/photos/$this->photoUrl";
        }
    }

    public function getPhotoUrlRaw()
    {
        return $this->photoUrl;
    }

    /**
     * Set the value of photoUrl.
     *
     * @return self
     */
    public function setPhotoUrl($photoUrl)
    {
        $this->photoUrl = $photoUrl;

        return $this;
    }
}
