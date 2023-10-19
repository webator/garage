<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailController extends AbstractController
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail(string $courriel, string $nom, string $prenom, string $telephone, string $sujet, string $message): void
    {
        $email = (new Email())
            ->from('info@webator.ch')
            ->to('info@webator.ch')
            ->subject('Prise de contact')
            ->html('Nom et prénom :'.$nom.' '.$prenom.'<br/>'.'Telephone:'.$telephone.'<br/>Courriel:'.$courriel.'<br/>Sujet:'.$sujet.'<br/>Message:'.$message);

        $this->mailer->send($email);
       
    }
}
