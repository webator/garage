<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ServicesRepository;
use App\Repository\VoituresRepository;
use App\Repository\HorairesRepository;
use App\Repository\ContactRepository;
use App\Repository\UtilisateursRepository;
use App\Repository\TemoignagesRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Contact;
use App\Entity\Temoignages;
use App\Form\TemoignagesType;
use App\Form\ContactType;
use App\Controller\MainController;


class HomeController extends AbstractController
{
    public function __construct(MailController $mailController)
    {
        $this->MailController = $mailController;
    }
    #[Route('/', name: 'app_home')]
    public function index(Request $request, UtilisateursRepository $UtilisateursRepository, ServicesRepository $ServicesRepository, VoituresRepository $VoituresRepository, HorairesRepository $HorairesRepository, TemoignagesRepository $TemoignagesRepository, ContactRepository $contactRepository): Response
    {
   
        $services = $ServicesRepository->findAll();
        $voitures = $VoituresRepository->findAll();
        $temoignages = $TemoignagesRepository->findActive();
        $horaires = $HorairesRepository->findSorted();

        $previousJour = null;
        $groupedResult = [];

        foreach ($horaires as $row) {
            if ($row['journom'] === $previousJour) {
                $groupedResult[count($groupedResult) - 1]['horaires'][] = $row['tranche'];
            } else {
                $groupedResult[] = [
                    'journom' => $row['journom'],
                    'horaires' => [$row['tranche']]
                ];
                $previousJour = $row['journom'];
            }
        }     
        //create form for contact
        $contact = new Contact;   
        
        $form = $this->createForm(ContactType::class, $contact);
        
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $contact->setdateenvoi(New \DateTime($contact->getdateenvoi()));
            
        }
        
        //create form temoignages
        $temoignage = new Temoignages;   
        
        $formTemoignage = $this->createForm(TemoignagesType::class, $temoignage);
        
        $formTemoignage->handleRequest($request);
        if($formTemoignage->isSubmitted() && $formTemoignage->isValid()){
            $TemoignagesRepository->save($temoignage, true); // Appelle la méthode save avec la date au format DateTime
            return $this->render('home/index.html.twig', [
                'temoignages' => $temoignages,
                'services' => $services,
                'voitures' => $voitures,
                'horaires' => $groupedResult,
                'formContact' => $form->createView(),
            ]);              
        }
        
        //if form correctly submitted and check, save to DB and return to customers table
        if($form->isSubmitted() && $form->isValid()){     
            $contactRepository->save($contact, true); // Appelle la méthode save avec la date au format DateTime
            
            $this->MailController->sendEmail($contact->getEmail(), $contact->getNom(), $contact->getPrenom(), $contact->getTelephone(), $contact->getSujet(), $contact->getMessage());
            
            return $this->render('home/index.html.twig', [
                'temoignages' => $temoignages,
                'services' => $services,
                'voitures' => $voitures,
                'horaires' => $groupedResult,
                'formTemoignage' => $formTemoignage->createView(),
            ]);            
        }

        return $this->render('home/index.html.twig', [
            'temoignages' => $temoignages,
            'services' => $services,
            'voitures' => $voitures,
            'horaires' => $groupedResult,
            'formContact' => $form->createView(),
            'formTemoignage' => $formTemoignage->createView(),
        ]);

    }
    
}
