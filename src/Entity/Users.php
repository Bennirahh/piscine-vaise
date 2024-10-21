<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $UserName = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $UserFirstname = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $UserEmail = null;

    #[ORM\Column]
    private ?int $UserPhone = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $UserBirthday = null;

    #[ORM\Column(nullable: true)]
    private ?bool $UserIsAdmin = null;

    /**
     * @var Collection<int, Role>
     */
    #[ORM\ManyToMany(targetEntity: Role::class, mappedBy: 'role')]
    private Collection $roles;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Sector $sector = null;

    /**
     * @var Collection<int, Reservation>
     */
    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'users')]
    private Collection $reservation;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->reservation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserName(): ?string
    {
        return $this->UserName;
    }

    public function setUserName(string $UserName): static
    {
        $this->UserName = $UserName;

        return $this;
    }

    public function getUserFirstname(): ?string
    {
        return $this->UserFirstname;
    }

    public function setUserFirstname(string $UserFirstname): static
    {
        $this->UserFirstname = $UserFirstname;

        return $this;
    }

    public function getUserEmail(): ?string
    {
        return $this->UserEmail;
    }

    public function setUserEmail(string $UserEmail): static
    {
        $this->UserEmail = $UserEmail;

        return $this;
    }

    public function getUserPhone(): ?int
    {
        return $this->UserPhone;
    }

    public function setUserPhone(int $UserPhone): static
    {
        $this->UserPhone = $UserPhone;

        return $this;
    }

    public function getUserBirthday(): ?\DateTimeInterface
    {
        return $this->UserBirthday;
    }

    public function setUserBirthday(\DateTimeInterface $UserBirthday): static
    {
        $this->UserBirthday = $UserBirthday;

        return $this;
    }

    public function isUserIsAdmin(): ?bool
    {
        return $this->UserIsAdmin;
    }

    public function setUserIsAdmin(?bool $UserIsAdmin): static
    {
        $this->UserIsAdmin = $UserIsAdmin;

        return $this;
    }

    /**
     * @return Collection<int, Role>
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    public function addRole(Role $role): static
    {
        if (!$this->roles->contains($role)) {
            $this->roles->add($role);
            $role->addRole($this);
        }

        return $this;
    }

    public function removeRole(Role $role): static
    {
        if ($this->roles->removeElement($role)) {
            $role->removeRole($this);
        }

        return $this;
    }

    public function getSector(): ?Sector
    {
        return $this->sector;
    }

    public function setSector(?Sector $sector): static
    {
        $this->sector = $sector;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservation(): Collection
    {
        return $this->reservation;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservation->contains($reservation)) {
            $this->reservation->add($reservation);
            $reservation->setUsers($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservation->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getUsers() === $this) {
                $reservation->setUsers(null);
            }
        }

        return $this;
    }
}
