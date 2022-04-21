<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Repository\PersonneRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/personne')]
class PersonneController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine)
    {}

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
}
