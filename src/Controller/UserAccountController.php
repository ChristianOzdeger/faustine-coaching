<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\DocumentRepository;
use App\Repository\MesureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/mon-compte", name="user_account_")
 */
class UserAccountController extends AbstractController
{
    /**
     * @Route("", name="read")
     */
    public function read(MesureRepository $mesureRepository, DocumentRepository $documentRepository) : Response
    {
        $user = $this->getUser();
        $userId = $user->getId();
        $mesures = $mesureRepository->listByUser($userId);
        $userDocuments = $documentRepository->listByUser($userId);

        return $this->render('user_account/read.html.twig', [
            'utilisateur' => $user,
            'mesures' => $mesures,
            'documents' => $userDocuments,
        ]);
    }

    /**
     * @Route("/modifier", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $user = $this->getUser();
        $form = $this->createForm(UtilisateurType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form->get('password')->getData();

            // Il est impossible de comparer directement le mot de passe reçu avec la valeur en BDD
            // Donc, si $password n'est pas null, on le met à jour dans l'objet $user
            if ($password != null) {
                // On utilise $userPasswordEncoder pour hasher le mot de passe
                $encodedPassword = $userPasswordEncoder->encodePassword($user, $password);
                $user->setPassword($encodedPassword);

                // On peut le faire en une seule ligne :
                // $user->setPassword($userPasswordEncoder->encodePassword($user, $password));
            }
           
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_account_read');
        }

        return $this->render('user_account/edit.html.twig', [
            'utilisateur' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/inscription", name="add", methods={"GET","POST"})
     */
    public function add(Request $request, UserPasswordEncoderInterface $userPasswordEncoder )
    {
        $user = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form->get('password')->getData();

            // Il est impossible de comparer directement le mot de passe reçu avec la valeur en BDD
            // Donc, si $password n'est pas null, on le met à jour dans l'objet $user
            if ($password != null) {
                // On utilise $userPasswordEncoder pour hasher le mot de passe
                $encodedPassword = $userPasswordEncoder->encodePassword($user, $password);
                $user->setPassword($encodedPassword);

                // On peut le faire en une seule ligne :
                // $user->setPassword($userPasswordEncoder->encodePassword($user, $password));
            }
           
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('messages', 'Le compte à bien été crée ! ');
            return $this->redirectToRoute('user_account_add');
        }


        return $this->render('user_account/add.html.twig', [
            'utilisateur' => $user,
            'form' => $form->createView(),
        ]);
    }

    
}
