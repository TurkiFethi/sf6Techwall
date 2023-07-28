<?php

namespace App\Service;

use Psr\Log\LoggerInterface;

class Helpers
{
    public function __construct(private LoggerInterface $langue)
    {
        
    }
    public function sayCc():string{
        return 'cc';
    }
}