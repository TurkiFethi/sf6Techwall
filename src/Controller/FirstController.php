<?php

namespace App\Controller;

use Doctrine\DBAL\Schema\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    
   #[Route('/first', name: 'first')]
    public function index(): Response
    {
       
        return $this->render('first/index.html.twig',[
            'name'=>'turki',
            'firstName'=>'Fethi'

        ]);
    }

   #[Route('/sayHello', name: 'say.hello')]
    public function sayHello(): Response
    {
        $rand=rand(0,10);
        echo($rand);
        if($rand==3){
             return $this->redirectToRoute('first');
        }
        return $this->forward('App\Controller\FirstController::index');
    }

    #[Route('/bonjour/{firstName}/{lastName}', name: 'bonjour')]
    public function bonjour(Request $request ,$firstName,$lastName): Response
    {
       //dd($request);
        return $this->render('first/bonjour.html.twig',[
            'nom'=>$firstName,
            'prenom'=>$lastName,
            'path'=>'    '

        ]);
    }
}
