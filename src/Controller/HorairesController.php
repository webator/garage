<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\HorairesRepository;
use App\Entity\Horaires;
use App\Form\HorairesType;

class HorairesController extends AbstractController
{
    #[Route('/admin/horaires', name: 'app_horaires')]
    public function index(HorairesRepository $repo): Response
    {
        $horaires = $repo->findAllReplaceDays();
        return $this->render('admin/horaires/index.html.twig', [
            'horaires' => $horaires
        ]);
    }
    #[Route('/admin/horaires/create', name:'app_horaires_create')]
    public function create(Request $request, HorairesRepository $repo) : Response {

        $Horaire = new Horaires;   
        $form = $this->createForm(HorairesType::class, $Horaire);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){

           
            $repo->save($Horaire, true);
                return $this->redirectToRoute('app_horaires');
            }

        return $this->render('admin/Horaires/create.html.twig', [
        'formView' => $form->createView(),
        ]);
        
    }
    #[Route('admin/horaires/edit/{id}', name:'app_horaires_edit')]
    public function edit(HorairesRepository $repo, Horaires $horaire, Request $request) : Response {
       
        $form = $this->createForm(HorairesType::class, $horaire);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
           
            
           $repo->save($horaire, true);
           return $this->redirectToRoute('app_horaires');
        }

        return $this->render('admin/horaires/edit.html.twig', [
           'formView' => $form->createView(),
        ]);
    }
    #[Route('admin/horaires/delete/{id}', name:'app_Horaires_delete')]
    public function delete(HorairesRepository $repo, int $id): Response
    {
      
    $horaire = $repo->find($id);
    if (!$horaire) {
        throw $this->createNotFoundException(
            'Pas trouvé'
        );
    }
    $repo->remove($horaire,1);
    
    
    $message = 'Supprimé';
    return new Response($message);
        
    } 
}
