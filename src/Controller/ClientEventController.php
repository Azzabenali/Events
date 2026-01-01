<?php

namespace App\Controller;

use App\Repository\EventRepository;
use App\Repository\CategoryRepository;
use App\Repository\LieuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;


class ClientEventController extends AbstractController
{
    #[Route('/events', name: 'client_event_index')]
    
public function index(
    Request $request,
    EventRepository $eventRepo,
    CategoryRepository $catRepo,
    LieuRepository $lieuRepo
): Response {

    $category = $request->query->get('category');
    $lieu     = $request->query->get('lieu');
    $date     = $request->query->get('date');
    $prix     = $request->query->get('prix');

    $events = $eventRepo->findByFilters(
        $category ? (int) $category : null,
        $lieu ? (int) $lieu : null,
        $date ?: null,
        $prix ? (float) $prix : null
    );

    return $this->render('client/event/index.html.twig', [
        'events' => $events,
        'categories' => $catRepo->findAll(),
        'lieux' => $lieuRepo->findAll(),
    ]);
}

    #[Route('/events/{id}', name: 'client_event_show')]
    public function show(int $id, EventRepository $eventRepository): Response
    {
        $event = $eventRepository->find($id);

        if (!$event) {
            throw $this->createNotFoundException('Event not found');
        }

        return $this->render('client/event/show.html.twig', [
            'event' => $event,
        ]);
    }
}
