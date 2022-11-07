<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Entity\Contact; 

class BaseController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function index(): Response
    {
        return $this->render('base/index.html.twig', [
            
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);

        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()){   
                $email = (new Email())
                ->from($form->get('email')->getData())
                ->to('jules.meurin@laposte.net')
                ->subject($form->get('sujet')->getData())
                ->text($form->get('message')->getData());
              
                $mailer->send($email);
               
                $this->addFlash('notice','Message envoyé');
                return $this->redirectToRoute('contact');
            }
        }

        return $this->render('base/contact.html.twig', [
            'form' => $form->createView()
        ]);
    } 




    #[Route('/apropos', name: 'apropos')] // étape 1
    public function apropos(): Response // étape 2
    {
        return $this->render('base/aPropos.html.twig', [ // étape 3
            
        ]);
    }

    #[Route('/mentions', name: 'mentions')] // étape 1
    public function mentionsLegales(): Response // étape 2
    {
        return $this->render('base/mentions.html.twig', [ // étape 3
            
        ]);
    }

} 
 
 
