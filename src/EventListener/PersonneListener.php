<?php

namespace App\EventListener;

use App\Event\AddPersonneEvent;
use App\Event\ListAllPersonneEvent;
use Psr\Log\LoggerInterface;

class PersonneListener
{

    public function __construct(private LoggerInterface $logger)
    {
        
    }
    public function onPersonneAdd(AddPersonneEvent $event){
        $this->logger->debug("cc je suis en train d'écouter l'evenement personne.add ". $event->getPersonne()->getName());
    }
    public function onListAllPersonnes(ListAllPersonneEvent $event){
        $this->logger->debug("Le nombre de personne dans la base est ". $event->getNbPersonne());
    }
    public function onListAllPersonnes2(ListAllPersonneEvent $event){
        $this->logger->debug("Le second Listener avec le nbre : ". $event->getNbPersonne());
    }
}
