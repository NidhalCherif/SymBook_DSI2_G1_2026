<?php

namespace App\Controller;

use App\Entity\Livres;
use App\Repository\LivresRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    #[Route('/livres/add', name: 'livres_add')]
    public function add(EntityManagerInterface $em): Response
    {
      $livre =new Livres();
      $livre->setTitre('titre 6')
            ->setQte(5)
          ->setPrix(random_int(10,200))
          ->setEditeur('editeur 5')
          ->setIsbn('11111111113')
          ->setImage('https://picsum.photos/400/?id=5')
          ->setDateEdition(new \DateTime('2025-2-4'))
          ->setResume('resumé de titre 5')
          ->setSlug('titre-5');

      $em->persist($livre);

        $em->flush();
       return $this->redirectToRoute('livres_lister');



    }

    #[Route('/livres/delete/{id}', name: 'livres_delete')]
    public function delete(LivresRepository $rep,$id, EntityManagerInterface $em): Response
    {
        $livre=$rep->find($id);

        $em->remove($livre);
        $em->flush();
        return $this->redirectToRoute('livres_lister');


    }
}
