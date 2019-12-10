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

use App\Service\Message;

class ArticleController extends AbstractController
{
    /**
     * @Route("/modif/Article", name="msg_modif")
     */
    public function alerterModif(Message $msg)
    {
    //    return $this->render('article/index.html.twig', [
    //      'controller_name' => 'ArticleController',
    //    ]);
        $article_prix = $msg->getPrixMessage("PC DELL", 600);
        
        $this->addFlash('New prix : ', $article_prix);
        
        return $this->render('article/test1.html.twig');
    }
    
    /**
     * @Route("/add_article", name="add_art")
     */
   public function creerArticle(Request $query) {
   
    $article = new Article();
    
    $form = $this->createForm(ArticleType::class, $article);
    
    $form->handleRequest($query);
        
    if ($form->isSubmitted() && $form->isValid()) {
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();     
        
        $query->getSession() 
              ->getFlashBag()
              ->add('success','Article ajouté avec succès');
       
        return $this->redirectToRoute('add_art');
    }
     return $this->render('article/add.html.twig',array('form'=>$form->createView()));     
}

     /**
      * @Route("/afficher_art", name="listeart")
      */
     
    public function afficherArticles(Request $request) {
        
        $em = $this->getDoctrine()->getManager();
        $valeur = $em->getRepository(Article::class)->findAll();    
        return $this->render('article/testRepo.html.twig',array('result'=>$valeur));
     }
     
    /**
      * @Route("/liste_art_categ/{id}", name="listeartcateg")
      */
     
    public function listerArtParCateg1(Request $request, $id) {
        
        $em = $this->getDoctrine()->getManager();
        $valeur = $em->getRepository(Article::class)->rechercherParCateg($id);    
        return $this->render('article/artParCateg.html.twig',array('result'=>$valeur));
     }
     
     /**
      * 
      *@Route("/article/update/{id}",name="upd_route")
      * 
      */     
     public function updateAction(Request $request, Session $session, $id){
         
        $article = new Article() ;
        $article = $this->getDoctrine()->getManager()->getRepository(Article::class)->getUnArticle($id);
        
        //$id = $session->get('login');
        $request->getSession()->getFlashBag()->add('notice', '');
        
        $form = $this->createForm(ArticleType::class, $article);
        
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $request->getSession()->getFlashBag()->add('success', 'Article modifié avec succès.');
                return $this->redirectToRoute('upd_route',array('id'=>$id));
            }
        }
        return $this->render( 'article/update.html.twig', array(
            'form' =>$form->createView(), 'article'=>$article));
    }
    
    /**
      * 
      *@Route("/article/update/register",name="r_register")
      * 
      */
    public function  register(){
        return $this->render("article/register.html.twig");
    }

    /**
      * 
      *@Route("/article/verif/supprimer/{id}",name="verif_del_art")
      * 
      */ 
    
    public function deleteVerif(Session $session, $id){
        $article = $this->getDoctrine()->getManager()->getRepository(Article::class)->getUnArticle($id);
        return $this->render('article/delete.html.twig', array('article'=>$article));
    }
    
    /**
      * 
      *@Route("/article/supprimer/{id}",name="del_art")
      * 
      */ 
    public function deleterArticle(Session $session, $id){

        $article = $this->getDoctrine()->getManager()->getRepository(Article::class)->getUnArticle($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();
        return $this->redirectToRoute('affichage_final');
    }
    /**
      * 
      *@Route("/article/afficher",name="affichage_final")
      * 
      */ 
    public function indexAction(Session $session){
        $id = $session->get('id');
        $article = $this->getDoctrine()->getManager()->getRepository(Article::class)->findAllArt();
        return $this->render('article/index.html.twig', array('articles'=>$article));
    }
}
