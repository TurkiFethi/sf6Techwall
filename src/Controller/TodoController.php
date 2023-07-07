<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

    // préfixe  route par /todo
    #[Route("/todo")]


class TodoController extends AbstractController

{


    // on a 5 type de routing (xml,yml,php,annotation,attribut)
    // route notion d'attribut
    #[Route('', name: 'todo')]
    // route notion d'anotation
    /**
     * @Route("/todo",name="todo")
     */


    public function index(Request $request): Response
    {
        $session = $request->getSession();
        //Afficher notre tableau de todo
        //sinon je l'inititialise puis l'affiche
        if (!$session->has(name: 'todos')) {
            $todos = [
                'achat' => 'acheter clé usb',
                'cours' => 'Finaliser mon cours',
                'correction' => 'corriger mes examens'
            ];
            $session->set('todos', $todos);
        }
        //si jai mon tableau de ma session je ne fait que l'afficher

        return $this->render('todo/index.html.twig');
    }

    #[Route(
        '/add/{name?test}/{content?test}',
         name: 'todo.add'
         )]
    public function addTodo(Request $request, $name, $content): RedirectResponse
    {

        $session  = $request->getSession();

        //vérifier si j'ai mon tableau de todo dans la session
        if ($session->has('todos')) {
            //si oui
            //vérifier si on a déja un todo avec le meme name
            $todos = $session->get('todos');
            if (isset($todos[$name])) {
                //si oui afficher erreur 
                $this->addFlash('info', "Le todo d'id name existe déja dans la lise");
            } else {
                //si non on l'ajouter puis on affiche un message succés
                $todos[$name] = $content;
                $session->set('todos', $todos);
                $this->addFlash('success', "Le todo d'id name a été ajouter avec succés");
            }
        } else {
            // si non
            //aficher une erreur e on va redirger vers le controlleur index
            $this->addFlash('error', "La liste des todos n'est pas encore initialisée");
        }
        return $this->redirectToRoute('todo');
    }

    #[Route('/update/{name}/{content}', name: 'todo.update')]
    public function updateTodo(Request $request, $name, $content): RedirectResponse
    {
        $session = $request->getSession();
        // Vérifier si j ai mon tableau de todo dans la session
        if ($session->has('todos')) {
            // si oui
            // Vérifier si on a déjà un todd avec le meme name
            $todos = $session->get('todos');
            if (!isset($todos[$name])) {
                // si oui afficher errerur
                $this->addFlash('error', "Le todo d'id $name n'existe pas dans la liste");
            } else {
                // si non on l'ajouter et on affiche un message de succès
                $todos[$name] = $content;
                $session->set('todos', $todos);
                $this->addFlash('success', "Le todo d'id $name a été modifié avec succès");
            }
        } else {
            // si non
            // afficher une erreur et on va redirger vers le controlleur index
            $this->addFlash('error', "La liste des todos n'est pas encore initialisée");
        }
        return $this->redirectToRoute('todo');
    }




    #[Route('/delete/{name}', name: 'todo.delete')]
    public function deleteTodo(Request $request, $name): RedirectResponse
    {
        $session = $request->getSession();
        //vérifier si j'ai mon tableau de todo dans la sesion 
        if ($session->has('todos')) {
            //si oui
            // Vérifier si on a déja un todo de meme name
            $todos = $session->get('todos');
            if (!isset($todos[$name])) {
                //si oui afficher erreur
                $this->addFlash('error', "Le todo d'id $name n'existe pas dans la liste");
            } else {
                // si non on l'ajouter et on affiche un message de succés
                unset($todos[$name]);
                $session->set('todos', $todos);
                $this->addFlash('success', "Le todo d'id $name a été supprimer avec succés");
            }
            return $this->redirectToRoute('todo');
        }
    }

    #[Route('/reset', name: 'todo.reset')]
    public function resetTodo(Request $request): RedirectResponse
    {
        $session = $request->getSession();
        $session->remove('todos');
        return $this->redirectToRoute('todo');
    }
}
