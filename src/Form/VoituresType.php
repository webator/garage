<?php

namespace App\Form;

use App\Entity\Voitures;
use App\Entity\Marques;
use App\Repository\MarquesRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class VoituresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
            $builder
            ->add('marque', EntityType::class, [
                'label' => 'nom',
                'class' => Marques::class,
                'choice_label' => 'nom',
                'query_builder' => function (MarquesRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.nom', 'ASC'); // This is the ordering part
                },
            ])

            ->add('modele')
            ->add('description')
            ->add('technique')
            ->add('prix')
            ->add('image', FileType::class, [
                'label' => 'Image (JPG or PNG file)',
                'mapped' => false, // Tell Symfony this is not a property of the Entity
                'required' => false, // Allow no file to be uploaded
                'constraints' => [
                    new \Symfony\Component\Validator\Constraints\File([
                        'maxSize' => '2M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid JPG or PNG',
                    ])
                ],
            ])
            ->add('miseencirculation')
            ->add('kilometrage')

            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                
            ])  
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voitures::class,
        ]);
    }
}
