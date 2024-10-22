<?php 

// src/EventSubscriber/DataSubscriber.php

namespace App\EventSubscriber;

use App\Service\DataService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class DataSubscriber implements EventSubscriberInterface
{
    private DataService $dataService;

    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }

    
    public function onKernelController(ControllerEvent $event): void
    {
        $request = $event->getRequest();

        // Récupérer les données
        $users = $this->dataService->getAllUsers();
        $events = $this->dataService->getAllEvents();
        $reservations = $this->dataService->getAllReservations();
        $locations = $this->dataService->getAllLocations();
        $roles = $this->dataService->getAllRoles();
        $sectors = $this->dataService->getAllSectors();
        $equipements = $this->dataService->getAllEquipements();

        // Injecter les données dans la requête
        $request->attributes->set('users', $users);
        $request->attributes->set('events', $events);
        $request->attributes->set('reservations', $reservations);
        $request->attributes->set('locations', $locations);
        $request->attributes->set('roles', $roles);
        $request->attributes->set('sectors', $sectors);
        $request->attributes->set('equipements', $equipements);
    }
}
