<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Form\CategorieType;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CategoriesController extends AbstractController
{
    #[Route('/categories', name: 'categories')]
    public function lister(CategoriesRepository $rep): Response
    {  $categories = $rep->findAll();
        return $this->render('categories/lister.html.twig', [
            'categories' => $categories,
        ]);
    }
    #[Route('/categories/add', name: 'categories_add')]
    public function add(Request $request,EntityManagerInterface $em): Response
    {
        $cat = new Categories(); // objet vide
        $form = $this->createForm(CategorieType::class, $cat);
        $form->handleRequest($request); // faire le lien entre $form et request qui recupère les données
        if ($form->isSubmitted()&& $form->isValid()) {
           try {
               // 1 alimenter l'objet $cat par les données du formulaire
               $cat = $form->getData(); //getData retourne un objet cat

               //2 Persister cat et flush
               $em->persist($cat);
               $em->flush();

               //redirection vers liste des catégories
               $this->addFlash('success', "Catégorie ajoutée avec succèes");
               $this->addFlash('info', "Veuillez continuer l'ajout");
               return $this->redirectToRoute('categories');
           }catch (\Exception $e){
               $this->addFlash('danger', "Une erreur est survenue lors de l'ajout");
           }
        }
        return $this->render('categories/add.html.twig', ['f'=>$form]);
    }



}
