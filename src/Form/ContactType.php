<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $date = new \DateTime(); // Créez un objet DateTime

        
        $builder
            ->add('email')
            ->add('telephone')
            ->add('nom')
            ->add('prenom')
            ->add('sujet')
            ->add('message')
            ->add('dateenvoi', HiddenType::class,[
                'data' => $date->format('d.m.Y'),
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                
            ])  
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
