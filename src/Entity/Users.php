<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
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
    private ?string $email = null;

    #[ORM\Column]
    private ?int $UserPhone = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $UserBirthday = null;

    #[ORM\Column(nullable: true)]
    private ?bool $UserIsAdmin = null;

    // Propriétés de sécurité
    #[ORM\Column(type: Types::TEXT)]
    private ?string $password = null;

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

    /**
     * @var Collection<int, Event>
     */
    #[ORM\OneToMany(targetEntity: Event::class, mappedBy: 'users')]
    private Collection $events;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->reservation = new ArrayCollection();
        $this->events = new ArrayCollection();
    }

    // Getter et setter pour les propriétés existantes
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

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
     * @return array
     */
    public function getRoles(): array
    {
        // On convertit les rôles en tableau et on ajoute un rôle par défaut si nécessaire
        $roles = $this->roles->map(fn($role) => $role->getName())->toArray();  // Conversion des objets Role en noms de rôles
        $roles[] = 'ROLE_USER';  // Ajoute un rôle par défaut

        return $roles;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getSalt(): ?string
    {
        // Pas nécessaire avec bcrypt
        return null;
    }

    // Implémentation de la méthode manquante
    public function getUserIdentifier(): string
    {
        return $this->UserEmail;  // Ou $this->UserName selon ton cas
    }

    public function eraseCredentials(): void
    {
        // Efface les données sensibles après l'authentification
    }

    // Méthodes pour les rôles
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

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): static
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->setUsers($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): static
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getUsers() === $this) {
                $event->setUsers(null);
            }
        }

        return $this;
    }
}
