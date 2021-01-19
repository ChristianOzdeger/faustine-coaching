<?php

namespace App\Form;

use App\Entity\Composition;
use App\Form\IngredientType;
use App\Repository\IngredientRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompositionType extends AbstractType
{
    private $ingredientRepository;

    public function __construct(IngredientRepository $ingredientRepository)
    {
        $this->ingredientRepository = $ingredientRepository;
        
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantite')
            ->add('unite')
            //On utilise un SelectorType qui utilise les datatransformer
            ->add('ingredient', IngredientSelectorType::class, [])
            //On ajoute un listener pour l'evenement PRE_SUBMIT ou l'on appel la fonction onPreSubmit
            ->addEventlistener(FormEvents::PRE_SUBMIT, [$this, 'onPreSubmit'])
        ;
    }

    public function onPreSubmit(FormEvent $event){
        //On récupère les données envoyés par le formulaire
        $data  = $event->getData();
        //On récupère l'objet form pour pouvoir le modifier
        $form = $event->getForm();

        //On recherche l'ingrédient dans la base de données par son libelle
        $ingredient = $this->ingredientRepository->findByLibelle($data['ingredient']);
        
        //Si l'ingrédient n'est pas présent dans la base
        if(!$ingredient){
            
            //On change le type du champs ingrédient en IngredientType
            $form->add('ingredient', IngredientType::class);
         
            //On passe un tableau en valeur pour la clé ingrédient du tableau data
            $data['ingredient']= ['libelle' => $data['ingredient']];
         
            //On fournit les données à utiliser par l'évènement
            $event->setData($data);
            
        }
       
       //Si l'ingrédient est dans la base on ne chnage rien au fomulaire.

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Composition::class,
        ]);
    }
}
