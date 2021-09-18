<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(ContactFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $contactRequest = $form->getData();
            $user = $contactRequest->getContactUser();

            $entityManager = $this->getDoctrine()->getManager();

            $knowUser = $entityManager->getRepository(User::class)->findOneBy(["email" => $user->getEmail()]);

            // If is first contact request from user
            if(empty($knowUser)) {
                $user->setPassword('pass');
                $entityManager->persist($user);
            } else {
                $user = $knowUser;
            }

            $contactRequest->setContactUser($user);
            $entityManager->persist($contactRequest);

            $entityManager->flush();

            $this->addFlash('success', 'Nous avons bien reçu votre demande de contact, nous y répondrons dans les plus bref délais');
        }

        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
