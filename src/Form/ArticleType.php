<?php

namespace App\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Article;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder
                ->add('code',TextType::class,array('label' => 'Code', 'attr' => array('class' => 'form-control', 'placeholder'=>'Code')))
                ->add('designation',TextType::class,array('label' => 'Designation', 'attr' => array('required'=>true, 'class' => 'form-control', 'placeholder'=>'Designation')))
                ->add('qte', NumberType::class,array('label' => 'Quantité', 'attr' => array('class' => 'form-control', 'placeholder'=>'Quantité')))
                ->add('prix_unit', NumberType::class, array('label' => 'Prix unitaire', 'attr' => array('class' => 'form-control', 'placeholder'=>'Prix unitaire')))
               ->add('categorie', EntityType::class, array('class'=> 'App\Entity\Categorie',
                       'query_builder' => function (EntityRepository $er)  {
                        return $er->createQueryBuilder('v')
                                ->orderBy('v.libelle', 'ASC'); }
                    ,'choice_label' => 'libelle'
                    ,'multiple'  => false
                    ,'required' => true
                    ,'placeholder' => '--- Choisir une catégorie ---'
                    ,'choice_label' => 'libelle'))                  
                ->add('valider',SubmitType::class, array('label' => 'Valider', 'attr' => array('class' => 'btn btn-primary btn-block')))
                ->add('annuler',ResetType::class, array('label' => 'Quitter', 'attr' => array('class' => 'btn btn-primary btn-block')));
    }
 
        
public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
