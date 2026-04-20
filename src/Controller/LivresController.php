<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Livres;
use App\Form\AddLivreType;
use App\Form\CategorieType;
use App\Repository\LivresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/admin',name:'admin_')]
final class LivresController extends AbstractController
{
    #[Route('/livres', name: 'admin_livres')]
    public function index(): Response
    {
        return $this->render('livres/index.html.twig', [
            'controller_name' => 'LivresController',
        ]);
    }
    #[Route('/livres/lister', name: 'livres_lister')]
    public function lister(LivresRepository $rep,PaginatorInterface $paginator, Request $request): Response
    {

        //dd($livres);
        $livres = $paginator->paginate(
            $rep->findAll(), /* query NOT result */
            $request->query->getInt('page', 1), /* page number */
            10 /* limit per page */
        );

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
    public function add(Request $request,EntityManagerInterface $em): Response
    {
        $livre= new Livres(); // objet vide
        $form = $this->createForm(addLivreType::class, $livre);
        $form->handleRequest($request); // faire le lien entre $form et request qui recupère les données
        if ($form->isSubmitted()&& $form->isValid()) {
            try {
                // 1 alimenter l'objet $cat par les données du formulaire
                $livre = $form->getData(); //getData retourne un objet cat

                //2 Persister cat et flush
                $em->persist($livre);
                $em->flush();

                //redirection vers liste des catégories
                $this->addFlash('success', "Livre ajouté avec succèes");
                //$this->addFlash('info', "Veuillez continuer l'ajout");
                return $this->redirectToRoute('livres_lister');
            }catch (\Exception $e){
                $this->addFlash('danger', "Une erreur est survenue lors de l'ajout");
            }
        }
        return $this->render('livres/add.html.twig', ['f'=>$form]);
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
