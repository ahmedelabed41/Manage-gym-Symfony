<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('roles', ChoiceType::class, [
            'choices' => [
                'User' => 'ROLE_USER',
                'Admin' => 'ROLE_ADMIN',
                'Coach' => 'ROLE_COACH',
                // Add other roles as needed
            ],
            'multiple' => true,    // Allow multiple role selection
            'expanded' => false,
            'placeholder' => 'Select Roles',
        ])
        ->add('nom')
        ->add('prenom')
        ->add('telephone')
        ->add('cin')
        ->add('sexe')
        ->add('email')
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
