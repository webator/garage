<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UtilisateursRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\Utilisateurs;
use App\Form\UtilisateursType;

class UsersController extends AbstractController
{
    #[Route('/admin/users', name: 'app_users')]
    public function index(UtilisateursRepository $utilisateursRepository): Response
    {
        $utilisateurs = $utilisateursRepository->findAll();
        return $this->render('admin/users/index.html.twig', [
            
            'utilisateurs' => $utilisateurs
        ]);
    }
    #[Route('/admin/users/create', name:'app_users_create')]
    public function create(Request $request, UtilisateursRepository $repo, UserPasswordHasherInterface $passwordHasher) : Response {

        $Utilisateurs = new Utilisateurs;   
        $form = $this->createForm(UtilisateursType::class, $Utilisateurs);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
            $hashedPassword = $passwordHasher->hashPassword(
                $Utilisateurs,
                $Utilisateurs->getmotdepasse()
            );
            $Utilisateurs->setmotdepasse($hashedPassword);
            $repo->save($Utilisateurs, true);
                return $this->redirectToRoute('app_users');
            }


        return $this->render('admin/users/create.html.twig', [
        'formView' => $form->createView(),
        ]);
        
    }
    #[Route('admin/users/edit/{id}', name:'app_users_edit')]
    public function edit(UtilisateursRepository $repo, Utilisateurs $utilisateur, Request $request, UserPasswordHasherInterface $passwordHasher) : Response {
       
        $form = $this->createForm(UtilisateursType::class, $utilisateur);
        $form->handleRequest($request);
        $hashedPassword = $passwordHasher->hashPassword(
            $utilisateur,
            $utilisateur->getmotdepasse()
        );
        $utilisateur->setmotdepasse($hashedPassword);
        if($form->isSubmitted() && $form->isValid()){
           $repo->save($utilisateur, true);
           return $this->redirectToRoute('app_users');
        }

        return $this->render('admin/users/edit.html.twig', [
           'formView' => $form->createView(),
        ]);
    }
    #[Route('admin/users/delete/{id}', name:'app_users_delete')]
    public function delete(UtilisateursRepository $repo, int $id): Response
    {
      

    $utilisateur = $repo->find($id);
    if (!$utilisateur) {
        throw $this->createNotFoundException(
            'Pas trouvé'
        );
    }
    $repo->remove($utilisateur,1);
    
    $message = 'Supprimé';
    return new Response($message);
        
    } 
}
