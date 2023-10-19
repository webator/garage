<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\VoituresRepository;
use App\Entity\Voitures;
use App\Form\VoituresType;

class OccasionController extends AbstractController
{
    #[Route('/admin/occasion', name: 'app_occasions')]
    public function index(VoituresRepository $repo): Response
    {
        $occasions = $repo->findAll();
        return $this->render('admin/occasions/index.html.twig', [
            'occasions' => $occasions
        ]);
    }
    #[Route('/admin/occasion/create', name:'app_occasions_create')]
    public function create(Request $request, VoituresRepository $repo): Response
    {
        $voiture = new Voitures;   
        $form = $this->createForm(VoituresType::class, $voiture);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $uniqueId = uniqid();
                
                $newFilename = $uniqueId . '.jpg' ;
                
                $imageFile->move(
                    '../public/images/voitures/', 
                    $newFilename
                );
                
                $voiture->setImage($uniqueId);
            }
    
            $repo->save($voiture, true);
    
            return $this->redirectToRoute('app_occasions');
        }
    
        return $this->render('admin/Occasions/create.html.twig', [
            'formView' => $form->createView(),
        ]);
    }
    
    #[Route('admin/occasion/edit/{id}', name:'app_Occasions_edit')]
    public function edit(VoituresRepository $repo, Voitures $voiture, Request $request) : Response {
       
        $form = $this->createForm(VoituresType::class, $voiture);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $uniqueId = uniqid();
                
                $newFilename = $uniqueId . '.' . $imageFile->guessExtension();
                
                $imageFile->move(
                    '../public/images/voitures/', 
                    $newFilename
                );
                
                $voiture->setImage($uniqueId);
            }
           
           
            $repo->save($voiture, true);
           return $this->redirectToRoute('app_occasions');
        }

        return $this->render('admin/Occasions/edit.html.twig', [
           'formView' => $form->createView(),
        ]);
    }
    #[Route('admin/occasion/delete/{id}', name:'app_Occasions_delete')]
    public function delete(VoituresRepository $repo, int $id): Response
    {
      

    $occasion = $repo->find($id);
    if (!$occasion) {
        throw $this->createNotFoundException(
            'Pas trouvé'
        );
    }
    $repo->remove($occasion,1);
    

    $message = 'Supprimé';
    return new Response($message);
        
    } 
}
