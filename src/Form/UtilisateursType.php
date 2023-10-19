<?php

namespace App\Form;

use App\Entity\Utilisateurs;
use App\Entity\Roles;
use App\Repository\RolesRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UtilisateursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('courriel')
            ->add('nom')
            ->add('motdepasse', PasswordType::class)
            ->add('role', EntityType::class, [
                'label' => 'Role',
                'class' => Roles::class,
                'choice_label' => 'nom', // Assuming 'No' is the property to display
                'query_builder' => function (RolesRepository $er) { // Use the correct repository class
                    return $er->createQueryBuilder('p');

                },
            ])              
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                
            ])  
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateurs::class,
        ]);
    }
}
