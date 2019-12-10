<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Service;

use App\Entity\Article;
use Psr\Log\LoggerInterface;

/**
 * Description of MessageGenerator
 *
 * @author etudiant
 */
class Message {
    
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    
    public function getPrixMessage($article, $prix)
    {
        $message = "Le nouveau prix de ".$article." = ".$prix;
        
        $this->logger->info($message);
        return $message;
    }
}
