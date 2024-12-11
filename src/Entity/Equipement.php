<?php

namespace App\Entity;

use App\Repository\EquipementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipementRepository::class)]
class Equipement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $equipementName = null;

    #[ORM\Column]
    private ?int $equipementPrice = null;

    #[ORM\Column(nullable: true)]
    private ?bool $equipementRent = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $equipementDuration = null;

    /**
     * @var Collection<int, Reservation>
     */
    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'equipement')]
    private Collection $reservations;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $images = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEquipementName(): ?string
    {
        return $this->equipementName;
    }

    public function setEquipementName(string $equipementName): static
    {
        $this->equipementName = $equipementName;

        return $this;
    }

    public function getEquipementPrice(): ?int
    {
        return $this->equipementPrice;
    }

    public function setEquipementPrice(int $equipementPrice): static
    {
        $this->equipementPrice = $equipementPrice;

        return $this;
    }

    public function isEquipementRent(): ?bool
    {
        return $this->equipementRent;
    }

    public function setEquipementRent(bool $equipementRent): static
    {
        $this->equipementRent = $equipementRent;

        return $this;
    }

    public function getEquipementDuration(): ?\DateTimeInterface
    {
        return $this->equipementDuration;
    }

    public function setEquipementDuration(\DateTimeInterface $equipementDuration): static
    {
        $this->equipementDuration = $equipementDuration;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setEquipement($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getEquipement() === $this) {
                $reservation->setEquipement(null);
            }
        }

        return $this;
    }

    public function getImages(): ?string
    {
        return $this->images;
    }

    public function setImages(?string $images): static
    {
        $this->images = $images;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
