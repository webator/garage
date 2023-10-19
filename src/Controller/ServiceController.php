<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ServicesRepository;
use App\Entity\Services;
use App\Form\ServicesType;

class ServiceController extends AbstractController
{
    #[Route('/admin/services', name: 'app_services')]
    public function index(ServicesRepository $repo): Response
    {
        $services = $repo->findAll();
        return $this->render('admin/services/index.html.twig', [
            
            'services' => $services
        ]);
    }
    #[Route('/admin/services/create', name:'app_services_create')]
    public function create(Request $request, ServicesRepository $repo) : Response {

        $Service = new Services;   
        $form = $this->createForm(ServicesType::class, $Service);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $uniqueId = uniqid();
                
                $newFilename = $uniqueId . '.jpg' ;
                
                $imageFile->move(
                    '../public/images/services/', 
                    $newFilename
                );
                
                $Service->setImage($uniqueId.'.jpg');
            }
           
            $repo->save($Service, true);
                return $this->redirectToRoute('app_services');
            }

        return $this->render('admin/services/create.html.twig', [
        'formView' => $form->createView(),
        ]);
        
    }
    #[Route('admin/services/edit/{id}', name:'app_services_edit')]
    public function edit(ServicesRepository $repo, Services $service, Request $request) : Response {
       
        $form = $this->createForm(ServicesType::class, $service);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $uniqueId = uniqid();
                
                $newFilename = $uniqueId . '.jpg' ;
                
                $imageFile->move(
                    '../public/images/services/', 
                    $newFilename
                );
                
                $service->setImage($uniqueId.'.jpg');
            }
           $repo->save($service, true);
           return $this->redirectToRoute('app_services');
        }

        return $this->render('admin/services/edit.html.twig', [
           'formView' => $form->createView(),
        ]);
    }
    #[Route('admin/services/delete/{id}', name:'app_services_delete')]
    public function delete(ServicesRepository $repo, int $id): Response
    {
      
    $service = $repo->find($id);
    if (!$service) {
        throw $this->createNotFoundException(
            'Pas trouvé'
        );
    }
    $repo->remove($service,1);
    
    
    $message = 'Supprimé';
    return new Response($message);
        
    } 
}
