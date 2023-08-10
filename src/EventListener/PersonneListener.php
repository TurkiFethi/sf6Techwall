<?php

namespace App\EventListener;

use App\Event\AddPersonneEvent;
use Psr\Log\LoggerInterface;

class PersonneListener
{

    public function __construct(private LoggerInterface $logger)
    {
        
    }
    public function onPersonneAdd(AddPersonneEvent $event){
        $this->logger->debug("cc je suis en train d'écouter l'evenement personne.add ". $event->getPersonne()->getName());
    }
}
