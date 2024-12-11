<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $reservationCategory = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $reservationDate = null;

    #[ORM\Column]
    private ?int $reservationPeaopleNumber = null;

    #[ORM\Column]
    private ?int $reservationPrice = null;

    #[ORM\ManyToOne(inversedBy: 'reservation')]
    private ?Users $users = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?Event $event = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?Location $location = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?Equipement $equipement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReservationCategory(): ?string
    {
        return $this->reservationCategory;
    }

    public function setReservationCategory(string $reservationCategory): static
    {
        $this->reservationCategory = $reservationCategory;

        return $this;
    }

    public function getReservationDate(): ?\DateTimeInterface
    {
        return $this->reservationDate;
    }

    public function setReservationDate(\DateTimeInterface $reservationDate): static
    {
        $this->reservationDate = $reservationDate;

        return $this;
    }

    public function getReservationPeaopleNumber(): ?int
    {
        return $this->reservationPeaopleNumber;
    }

    public function setReservationPeaopleNumber(int $reservationPeaopleNumber): static
    {
        $this->reservationPeaopleNumber = $reservationPeaopleNumber;

        return $this;
    }

    public function getReservationPrice(): ?int
    {
        return $this->reservationPrice;
    }

    public function setReservationPrice(int $reservationPrice): static
    {
        $this->reservationPrice = $reservationPrice;

        return $this;
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): static
    {
        $this->users = $users;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): static
    {
        $this->event = $event;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getEquipement(): ?Equipement
    {
        return $this->equipement;
    }

    public function setEquipement(?Equipement $equipement): static
    {
        $this->equipement = $equipement;

        return $this;
    }
}
