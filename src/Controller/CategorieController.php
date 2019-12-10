<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Psr\Log\LoggerInterface;

use App\Entity\Categorie;
use App\Form\CategorieType;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="categorie")
     */
    public function index()
    {
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }
    
   /**
     * @Route("/categorie/add_categorie", name="add_categ")
     */
    
    public function creerCategorie(Request $query) {
                
    
    $categ = new Categorie();
    $form = $this->createForm(CategorieType::class, $categ);
    $form->handleRequest($query);
        
    if ($form->isSubmitted() && $form->isValid()) {
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($categ);
        $em->flush();     
        
        $query->getSession() 
              ->getFlashBag()
              ->add('success','Catégorie ajoutée avec succès');
       
        return $this->redirectToRoute('add_categ');
    }
        return $this->render('categorie/add.html.twig',array('form'=>$form->createView()));     
     }
     
/**
 * @Route("/products")
 */
public function list(LoggerInterface $logger)
{
    $logger->info('Look! I just used a service');

    // ...
}
}

