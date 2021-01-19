<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    /**
     * @Route("/", name="accueil")
     */
    public function index(): Response
    {
        return $this->render('main/accueil.html.twig');
    }

    /**
     * @Route("/a-propos", name="about")
     */
    public function about(): Response
    {
        return $this->render('main/about.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, MailerInterface $mailer)
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $contact->setNom($form->get('nom')->getData());
            $contact->setPrenom($form->get('prenom')->getData());
            $contact->setEmail($form->get('email')->getData());
            $contact->setTelephone($form->get('telephone')->getData());
            $contact->setSubject($form->get('subject')->getData());
            $contact->setMessage($form->get('message')->getData());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

            // On crée le mail
            $email = (new TemplatedEmail())
                ->from($form->get('email')->getData())
                ->to('faustine.meurisse@gmail@gmail.com')
                ->subject($form->get('subject')->getData())
                ->htmlTemplate('main/contact-submit.html.twig')
                ->context([
                    'nom' => $form->get('nom')->getData(),
                    'prenom' => $form->get('prenom')->getData(),
                    'mail' => $form->get('email')->getData(),
                    'telephone' => $form->get('telephone')->getData(),
                    'subject' => $form->get('subject')->getData(),
                    'message' => $form->get('message')->getData(),
                ]);

            //On envoie le mail
            $mailer->send($email);

            // On confirme et on redirige sur l'accueil
            $this->addFlash('messages', 'Votre message a bien été envoyé, vous recevrez une réponse très prochainement !');

            return $this->redirectToRoute('accueil');
        }

        return $this->render('main/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/services/sport", name="services_sport")
     */
    public function sport(): Response
    {
        return $this->render('services/sport.html.twig');
    }

    /**
     * @Route("/services/nutrition", name="services_nutrition")
     */
    public function nutrition(): Response
    {
        return $this->render('services/nutrition.html.twig');
    }
}
