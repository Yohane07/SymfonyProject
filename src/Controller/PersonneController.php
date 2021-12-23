<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\PersonneType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonneController extends AbstractController
{

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


    #[Route('personne/ajouter', name:'personne_ajouter')]
    public function ajouter(Request $request, ManagerRegistry $manager):Response
    {
        //créer uen catégorie vide
        $personne = new Personne();

        $form = $this->createForm(PersonneType::class, $personne);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            //entity manager
            $em=$manager->getManager();

            //dis a l'entity manager que je veux enregister ma catégorie
            $em->persist($personne);//Trouver pourquoi il ne reconait pas ce persist mais reconnais celui du modifier



            //je déclenche la requête
            $em->flush();

            //je retourne à l'accueil
            return $this->redirectToRoute("home");
        }

        return $this->render('personne/ajouter.html.twig', [
            "formulaire"=>$form->createView()
        ]);
    }

    #[Route('personne/modifier/{id}', name:'personne_modifier')]
    public function personne_modifier($id, Request $request, ManagerRegistry $doctrine){
        $repo=$doctrine->getRepository(Personne::class);
        $personne=$repo->find($id);

        $form = $this->createForm(PersonneType::class, $personne);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $em=$doctrine->getManager();


            $em->persist($personne);

            $em->flush();

            return $this->redirectToRoute("home");
        }

        return $this->render("personne/modifier.html.twig", [
            "formulaire"=>$form->createView()
        ]);
    }


}
