<?php

namespace App\Controller;

use App\Entity\Mesure;
use App\Form\MesureType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MesureController extends AbstractController
{
    /**
     * @Route("/mon-suivi/modifier/{id}", name="measured_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Mesure $mesure)
    {
        $form = $this->createForm(MesureType::class, $mesure);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_account_read');
        }

        return $this->render('mesure/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/mon-suivi/ajouter/", name="measured_add", methods={"GET","POST"})
     */
    public function add(Request $request)
    {
        $mesure = new Mesure();

        $form = $this->createForm(MesureType::class, $mesure);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $mesure->setUtilisateur($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($mesure);
            $em->flush();
            
            return $this->redirectToRoute('user_account_read');
        }

        return $this->render('mesure/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/mon-suivi/supprimer/{id}", name="measured_delete", methods={"GET","POST"})
     */
    public function delete(Request $request, Mesure $mesure)
    {
       
        $em = $this->getDoctrine()->getManager();
        $em->remove($mesure);
        $em->flush();
        return $this->redirectToRoute('user_account_read');
        

    }

}
