<?php 

namespace App\Controller\Front;
use App\Entity\Users;
use App\Entity\Reservation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UsersRepository;
use App\Repository\ReservationRepository;



class UsersController extends AbstractController
{
    #[Route('/test', name: 'users_list')]

        public function index(UsersRepository $usersRepository, ReservationRepository $reservationRepository): Response 
    {
        $users = $usersRepository->findAll();
        $reservations = $reservationRepository->findAll();
        
        return $this->render('index.html.twig',
        [
            'users' => $users,
            'reservations' => $reservations
    ]);
    }
}