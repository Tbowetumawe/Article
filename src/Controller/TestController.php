<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\Query\AST\Join;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Article;
use App\Form\ArticleType;

class TestController extends AbstractController
{
    /**
     * @Route("/article", name="article")
     */
    public function index()
    {
    //    return $this->render('article/index.html.twig', [
    //      'controller_name' => 'ArticleController',
    //    ]);
        
        return $this->render('article/test1.html.twig');
    }
    
     /*
      * 
      * @Route("/test",name="route1")
      * 
      */
     public function testerTwig(Request $request, SessionInterface $session) {
         
        //$session = new Session();
     

        // set and get session attributes
        $session->set('couleur', 'bleue');
        $session->get('couleur');
        
        $session->set('modele', 'circulaire');
        $session->get('modele');
        
        $val1 = 'lycée louis armand';
        $val2 = array("Laroussi","Youcef",10);
        $content = $this->render('article/test2.html.twig', array("val1"=>$val1,"val2"=>$val2));
        return $content;
     }
     
     /**
      * @Route("/afficher_art/{id}", name="listeart")
      */
     

}


