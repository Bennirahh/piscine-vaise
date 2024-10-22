<?php 

// src/Service/DataService.php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Event; // Autres entités que tu veux récupérer
use App\Entity\Reservation; // Autres entités que tu veux récupérer

class DataService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAllUsers(): array
    {
        return $this->entityManager->getRepository(Users::class)->findAll();
    }

    public function getAllEvents(): array
    {
        return $this->entityManager->getRepository(Event::class)->findAll();
    }

    public function getAllReservations(): array
    {
        return $this->entityManager->getRepository(Reservation::class)->findAll();
    }

    public function getAllLocation(): array
    {
        return $this->entityManager->getRepository(Location::class)->findAll();
    }

    public function getAllRole(): array
    {
        return $this->entityManager->getRepository(Role::class)->findAll();
    }

    public function getAllSector(): array
    {
        return $this->entityManager->getRepository(Sector::class)->findAll();
    }

    public function getAllEquipement(): array
    {
        return $this->entityManager->getRepository(Equipement::class)->findAll();
    }


    

    // Ajoute d'autres méthodes pour récupérer des données spécifiques
}
