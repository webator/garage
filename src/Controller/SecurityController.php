<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Translation\TranslatorInterface;
use App\Repository\UtilisateursRepository;
use App\Entity\Utilisateurs;
use App\Form\UserType;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: 'admin/logout', name: 'app_logout')]
    public function logout(): void
    {
        
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
    #[Route(path: '/users', name: 'app_users')]
    public function manageUsers(UserRepository $repo)
    {
        $users = $repo->findAll();
        
        return $this->render('security/users.html.twig', ['users' => $users]);

    }    
    #[Route(path: '/users/edit/{id}', name: 'app_users_edit')]
    public function editUser($id, UserRepository $repo, User $user, Request $request, UserPasswordHasherInterface $userPasswordHasher)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Check if password has been changed
            
            $plainPassword = $form->get('password')->getData();
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $plainPassword
                )
            );
    
            $repo->save($user, true);
    
            return $this->redirectToRoute('app_users', ['status' => 'useredited']);
        }
    
        return $this->render('security/edit.html.twig', [
            'formView' => $form->createView(),
        ]);
    }
  



    #[Route('/users/create', name:'app_users_create')]
    public function create(Request $request, UserRepository $repo, UserPasswordHasherInterface $userPasswordHasher) : Response {
        //create form for customer
        $user = new User;   
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        //if form correctly submitted and check, save to DB and return to customers table
        if($form->isSubmitted() && $form->isValid()){
            $plainPassword = $form->get('password')->getData();
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $plainPassword
                )
            );
           $repo->save($user, true);
           return $this->redirectToRoute('app_users', ['status' => 'usercreated']);
        }

        //show view with form to create product
        return $this->render('security/create.html.twig', [
           'formView' => $form->createView(),
        ]);
        
    }   
    #[Route('users/delete/{id}', name:'app_users_delete')]
    
    public function delete(UserRepository $repo, $id): Response
    {
      
     //find statement to delete
    $user = $repo->find($id);
    if (!$user) {
        throw $this->createNotFoundException(
            'No user found for id '.$id
        );
    }
    $repo->remove($user,1);
    
    
    //return statement disabled
    $message = 'User deleted';
    return new Response($message);
        
    }       
}