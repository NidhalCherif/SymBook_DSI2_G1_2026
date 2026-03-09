<?php

namespace App\Controller;

use App\Repository\LivresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LivresController extends AbstractController
{
    #[Route('/livres', name: 'livres')]
    public function index(): Response
    {
        return $this->render('livres/index.html.twig', [
            'controller_name' => 'LivresController',
        ]);
    }
    #[Route('/livres/lister', name: 'livres_lister')]
    public function lister(LivresRepository $rep): Response
    {
        $livres=$rep->findAll();
        //dd($livres);
        return $this->render('livres/lister.html.twig', [
            'livres' => $livres,
        ]);
    }
    #[Route('/livres/show/{id}', name: 'livres_show')]
    public function show(LivresRepository $rep,$id): Response
    {
        $livre=$rep->find($id);
        //dd($livres);
        return $this->render('livres/show.html.twig', [
            'livre' => $livre,
        ]);
    }
}
