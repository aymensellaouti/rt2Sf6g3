<?php

namespace App\Controller;

use App\Entity\Person;
use App\Entity\Voiture;
use App\Form\VoitureType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/voiture')]
class VoiturController extends AbstractController
{
    private $manager;
    private $repository;
    public function __construct(private ManagerRegistry $doctrine)
    {
        $this->manager = $this->doctrine->getManager();
        $this->repository = $this->doctrine->getRepository(Voiture::class);
    }
    #[Route('/', name: 'app_voitur')]
    public function index(): Response
    {
        $voitures = $this->repository->findAll();
        return $this->render('voitur/index.html.twig', [
            'voitures' => $voitures,
        ]);
    }
    #[Route('/edit/{id?0}', name: 'app_voitur_edit')]
    public function edit(Request $request, Voiture $voiture = null): Response
    {
        if (!$voiture) {
            $voiture = new Voiture();
        }
//        $voiture->setColor('blue');
        // Création du form en tant qu'objet
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->remove('owner');
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
//            Todo ?? Ajouter voiture dans la bd
            $this->manager->persist($voiture);
            $this->manager->flush();
            return $this->redirectToRoute('app_voitur');
        }
        return $this->render('voitur/edit.html.twig', [
            // On a transformé le form en une view et l'a envoyé à TWIG
            'form' => $form->createView(),
        ]);
    }
}
