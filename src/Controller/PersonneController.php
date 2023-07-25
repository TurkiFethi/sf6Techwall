<?php

namespace App\Controller;

use App\Entity\Personne;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



#[Route('personne')]
class PersonneController extends AbstractController
{
    #[Route('/', name: 'personne.list')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Personne::class);
        $personne = $repository->findAll();
        return $this->render('personne/index.html.twig', ['personne' => $personne]);
    }

    #[Route('/alls/{page?1}/{nbre?12}', name: 'personne.list.alls')]
    public function indexAlls(ManagerRegistry $doctrine, $page, $nbre): Response {
        //        echo ($this->helper->sayCc());
                $repository = $doctrine->getRepository(Personne::class);
                $nbPersonne = $repository->count([]);
             
                // 24
                $nbrePage = ceil($nbPersonne / $nbre) ;
        
                $personnes = $repository->findBy([], ['age'=>'asc'],$nbre, ($page - 1 ) * $nbre);
            
        
                return $this->render('personne/index.html.twig', [
                    'personne' => $personnes,
                    'isPaginated' => true,
                    'nbrePage' => $nbrePage,
                    'page' => $page,
                    'nbre' => $nbre
                ]);
            }

    /*  #[Route('/{id<\d+>}', name: 'personne.detail')]
    public function detail(ManagerRegistry $doctrine ,$id): Response
    {
        $repository = $doctrine->getRepository(Personne::class);
        $personne = $repository->find($id);
        if(!$personne){
               $this->addFlash('error', "La personne d'id $id n'existe pas ");
            return $this->redirectToRoute('personne.list');
        }


       return $this->render('personne/detail.html.twig', ['personne' => $personne]);
    }*/
    // une fonction equivalent de find by id
    #[Route('/{id<\d+>}', name: 'personne.detail')]
    public function detail(Personne $personne = null): Response
    {

        if (!$personne) {
            $this->addFlash('error', "La personne n'existe pas ");
            return $this->redirectToRoute('personne.list');
        }


        return $this->render('personne/detail.html.twig', ['personne' => $personne]);
    }



    #[Route('/add', name: 'personne.add')]
    public function addPersonne(ManagerRegistry $doctrine): Response
    {
        //$this->getDoctrine() : version sf <= 5

        $entityManager = $doctrine->getManager();
        $personne = new Personne();
        $personne->setFirstName('fethi');
        $personne->setName('turki');
        $personne->setAge('33');

        //   $personne2 = new Personne();
        // $personne2->setFirstName('mouadh');
        // $personne2->setName('ayachi');
        // $personne2->setAge('32');


        // Ajouter l'operation de d'insertion de la personne dans mon transaction
        $entityManager->persist($personne);
        // $entityManager->persist($personne2);

        // Exécuter la transaction todo
        $entityManager->flush();
        return $this->render('personne/detail.html.twig', [
            'personne' => $personne,
        ]);
    }

    #[Route('/delete/{id}', name: 'personne.delete')]
    public function deletePersonne(Personne $personne=null, ManagerRegistry $doctrine): RedirectResponse {

                // Récupérer la personne
                if ($personne) {
                    // Si la personne existe => le supprimer et retourner un flashMessage de succés
                    $manager = $doctrine->getManager();
                    // Ajoute la fonction de suppression dans la transaction
                    $manager->remove($personne);
                    // Exécuter la transacition
                    $manager->flush();
                    $this->addFlash('success', "La personne a été supprimé avec succès");
                } else {
                    //Sinon  retourner un flashMessage d'erreur
                    $this->addFlash('error', "Personne innexistante");
                }
                return $this->redirectToRoute('personne.list.alls');

            }

            #[Route('/update/{id}/{name}/{firstname}/{age}', name: 'personne.update')]
            public function updatePersonne(Personne $personne = null, ManagerRegistry $doctrine, $name, $firstname, $age) {
                //Vérifier que la personne à mettre à jour existe
                if ($personne) {
                    // Si la personne existe => mettre a jour notre personne + message de succes
                    $personne->setName($name);
                    $personne->setFirstname($firstname);
                    $personne->setAge($age);
                    $manager = $doctrine->getManager();
                    $manager->persist($personne);
        
                    $manager->flush();
                    $this->addFlash('success', "La personne a été mis à jour avec succès");
                }  else {
                    //Sinon  retourner un flashMessage d'erreur
                    $this->addFlash('error', "Personne innexistante");
                }
                return $this->redirectToRoute('personne.list.alls');
            }
}
