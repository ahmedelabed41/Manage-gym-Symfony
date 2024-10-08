<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Bridge\Twig\Extension\AssetExtension;
use Symfony\Component\Validator\Constraints as Assert;




class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class, [
            'label' => false,
            'attr' => [
                'class' => 'form-control',
                'placeholder' => 'Nom',
            ],
            'row_attr' => [
                'class' => 'col-md-12'
            ]
        ])
    
        ->add('prenom', TextType::class, [
            'label' => false,
            'attr' => [
                'class' => 'form-control',
                'placeholder' => 'Prénom'
            ],
            'row_attr' => [
                'class' => 'col-md-12'
            ]
        ])

            ->add('telephone', NumberType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Numéro du téléphone'
                ],
                'row_attr' => [
                    'class' => 'col-md-12'
                ]
            ])
    
            ->add('cin', NumberType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Numéro de la CIN'
                ],
                'row_attr' => [
                    'class' => 'col-md-12'
                ]
            ])
    
            ->add('sexe', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'Sexe' => 'disabled',
                    'Homme' => 'homme',
                    'Femme' => 'femme',
                ],
                'choice_attr' => function($choiceValue, $key, $value) {
                    if ($choiceValue == 'disabled') {
                        return ['disabled' => 'disabled'];
                    }
                    return [];
                },
                'attr' => ['class' => 'form-control'],
            ])
            
    
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => [
                    'autocomplete' => 'email',
                    'class' => 'form-control',
                    'placeholder' => 'Email'
                ],
            ])

            ->add('plainPassword', PasswordType::class, [
                'label' => false,
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => 'form-control block mt-10 mx-auto border-b-2 w-1/5 h-20 text-2xl outline-none',
                    'placeholder' => 'Mot de passe'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

