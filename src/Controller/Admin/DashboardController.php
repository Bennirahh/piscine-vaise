<?php

// src/Controller/Admin/DashboardController.php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Users;
use App\Entity\Reservation;
use App\Entity\Equipement;
use App\Entity\Sector;
use App\Entity\Event;
use App\Entity\Location;
use App\Entity\Role;
use App\Entity\Contact;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'adminn')]
    public function index(): Response
    {
        // Obtenir l'utilisateur actuellement connecté
        $user = $this->getUser();

        // Ajouter des logs pour déboguer
        error_log('Utilisateur connecté : ' . ($user ? $user->getUserIdentifier() : 'Aucun'));

        // Vérifier si l'utilisateur est administrateur
        if (!$user || !$user instanceof Users || !$user->isUserIsAdmin()) {
            error_log('Accès refusé pour l\'utilisateur : ' . ($user ? $user->getUserIdentifier() : 'Aucun'));
            // Rediriger vers la page d'accueil si l'utilisateur n'est pas admin
            return new RedirectResponse($this->generateUrl('profil'));
        }

        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Piscine Vaise');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-users', Users::class);
        yield MenuItem::linkToCrud('Réservations', 'fas fa-calendar', Reservation::class);
        yield MenuItem::linkToCrud('Équipements', 'fas fa-tools', Equipement::class);
        yield MenuItem::linkToCrud('Specialité du professeurs', 'fas fa-chalkboard-teacher', Sector::class);
        yield MenuItem::linkToCrud('Événements', 'fas fa-calendar-alt', Event::class);
        yield MenuItem::linkToCrud('Lieu', 'fas fa-calendar-alt', Location::class);
        yield MenuItem::linkToCrud('Role', 'fas fa-calendar-alt', Role::class);
        yield MenuItem::linkToCrud('Contact', 'fas fa-envelope',Contact::class);
    }
}
