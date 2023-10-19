<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TemoignagesRepository;
use App\Entity\Temoignages;
use App\Form\TemoignagesType;

class TemoignagesController extends AbstractController
{
    #[Route('/admin/temoignages', name: 'app_temoignages')]
    public function index(TemoignagesRepository $repo): Response
    {
        $temoignages = $repo->findSortedByStatusAndDate();
        return $this->render('admin/temoignages/index.html.twig', [
            'temoignages' => $temoignages
        ]);
    }
    #[Route('/admin/temoignages/create', name:'app_temoignages_create')]
    public function create(Request $request, TemoignagesRepository $repo) : Response {

        $Temoignages = new Temoignages;   
        $form = $this->createForm(TemoignagesType::class, $Temoignages);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $repo->save($Temoignages, true);
                return $this->redirectToRoute('app_temoignages');
            }

        return $this->render('admin/temoignages/create.html.twig', [
        'formView' => $form->createView(),
        ]);
        
    }
    #[Route('admin/temoignages/delete/{id}', name:'app_temoignages_delete')]
    public function delete(TemoignagesRepository $repo, int $id): Response
    {

        $Temoignages = $repo->find($id);
        if (!$Temoignages) {
            throw $this->createNotFoundException(
                'Pas trouvé'
            );
        }
        $repo->remove($Temoignages,1);
        
        $message = 'Supprimé';
        return new Response($message);
            
    } 
    #[Route('admin/temoignages/confirm/{id}', name:'app_temoignages_confirm')]
    public function confirm(TemoignagesRepository $repo, int $id): Response
    {

        $Temoignages = $repo->find($id);
        if (!$Temoignages) {
            throw $this->createNotFoundException(
                'Pas trouvé'
            );
        }
        $Temoignages->setStatus(1);
        $repo->save($Temoignages,1);
        
        $message = 'Confirmé';
        return new Response($message);
            
    } 
}
