<?php

namespace App\Controller;

use App\Entity\Personne;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonneController extends AbstractController
{
//    #[Route('/personne', name: 'personne')]
//    public function index(): Response
//    {
//        return $this->render('personne/index.html.twig', [
//            'controller_name' => 'PersonneController',
//        ]);
//    }

//    /**
//     * @param EntityManagerInterface $repository
//     * @return Response
//     */

    /**
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/', name: 'home')]
    public function index(EntityManagerInterface $manager ): Response
    {
       $personne = $manager ->getRepository(Personne::class)->findBy([],['id' => 'DESC']);

        return $this->render('personne/index.html.twig', [
            'personnes' => $personne,
        ]);
    }


}
