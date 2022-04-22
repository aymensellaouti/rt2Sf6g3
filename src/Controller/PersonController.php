<?php

namespace App\Controller;

use App\Entity\Person;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/person')]
class PersonController extends AbstractController
{
    private $manager;
    private $repository;
    public function __construct(private ManagerRegistry $doctrine)
    {
        $this->manager = $this->doctrine->getManager();
        $this->repository = $this->doctrine->getRepository(Person::class);
    }
    #[Route('/', name: 'app_person')]
    public function index(): Response
    {
        $persons = $this->repository->findAll();
        return $this->render('person/index.html.twig', [
            'persons' => $persons,
        ]);
    }
    #[Route('/delete/{id}', name: 'app_person_delete')]
    public function delete(Person $person = null): Response
    {
//        $person = $this->repository->find($id);
        if(!$person) {
            throw new NotFoundHttpException("Not Found");
        } else {
            $this->manager->remove($person);
            $this->manager->flush();
            $this->addFlash('success', "Personne supprimée avec succès");
            return $this->forward('App\\Controller\\PersonController::index');
        }
    }
}
