<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TabController extends AbstractController
{
    #[Route('/tab/{nb<\d+>?5}', name: 'app_tab')]
    public function index($nb): Response
    {
        $notes=[];
        for($i=0;$i<$nb;$i++){
            $notes[]=rand(0,20);
        }
       
        return $this->render('tab/index.html.twig', [
        'notes'=>$notes,
        ]);
      
    }
    #[Route('/tab/users', name: 'users_tab')]
    public function user(): Response
    {
        $users  =[
            ['firstName'=>'fethi','lastName'=>'turki','age'=>'33'],
            ['firstName'=>'khoubaib','lastName'=>'ezzine','age'=>'31'],
            ['firstName'=>'mouadh','lastName'=>'ayachi','age'=>'32'],
        ];
        return $this->render('tab/users.html.twig', [
            'users'=>$users
        ]);
      
    }
}
