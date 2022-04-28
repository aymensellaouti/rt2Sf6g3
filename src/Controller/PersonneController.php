<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\PersonneType;
use App\Repository\PersonneRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/personne')]
class PersonneController extends AbstractController
{
    private $manager;
    public function __construct(private ManagerRegistry $doctrine)
    {
        $this->manager = $this->doctrine->getManager();
    }

    #[Route('/', name: 'app_personne')]
    public function index(PersonneRepository $repository): Response
    {
        $personnes = $repository->findAll();
        return $this->render('personne/index.html.twig', [
            'personnes' => $personnes
        ]);
    }
    #[Route('/delete/{id}', name: 'app_personne_delete')]
    public function deletePersonne(Personne $personne = null) {
        dump($personne);
        if(!$personne) {
            $this->addFlash('error', "La personne n'existe pas !!");
            return throw new NotFoundHttpException('Personne innexistante');
        } else {
            $this->doctrine->getManager()->remove($personne);
            $this->addFlash('success', "Personne supprimé avec succès");
            $this->doctrine->getManager()->flush();
        }
        return $this->redirectToRoute('app_personne');
    }
    #[Route('/edit/{id?0}', name: 'personne_edit')]
    public function addPersonne(Request $request, Personne $personne = null) {
        if (!$personne) {
            $personne = new Personne();
        }
//        $personne->setName('aymen');

        $form = $this->createForm(PersonneType::class, $personne);
        $form->remove('createdAt');
        $form->remove('updatedAt');
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
//            Todo add Personne in DB then show the person's list
            $this->manager->persist($personne);
            $this->manager->flush();
            return $this->redirectToRoute('app_personne');
        }
        return $this->render('personne/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
