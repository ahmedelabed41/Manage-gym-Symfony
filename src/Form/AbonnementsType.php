<?php

namespace App\Form;

use App\Entity\Abonnements;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class AbonnementsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            /*->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'nom',
                'choice_value' => 'id',
                'placeholder' => 'Sélectionner un adhérent'
            ])*/
            /*->add('dateDebut', DateType::class, [
                'widget' => 'single_text', // Utilisation d'un widget date
            ])
            ->add('dateFin', DateType::class, [
                'widget' => 'single_text',
            ])*/
            ->add('description', ChoiceType::class, [
                'choices' => [
                    'Masse musculaire' => 'masse musculaire',
                    'Perte du poids' => 'perte du poids',
                    'Cardio' => 'cardio',
                ],
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'col-sm-6'],
            ],)
            ->add('payement', ChoiceType::class, [
                'choices' => [
                    '80' => '80',
                    '220' => '220',
                    '400' => '400',
                    '760' => '760',
                ],
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'col-sm-6'],
            ]);
            if ($options['include_statut']) {
                $builder->add('statut', ChoiceType::class, [
                    'choices' => [
                        'en attente' => 'en attente',
                        'confirmé' => 'confirmé',
                    ],
                    'attr' => ['class' => 'form-control'],
                    'row_attr' => ['class' => 'col-sm-6'],
                ]);
            } else {
                $builder->add('statut', HiddenType::class);
            }
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Abonnements::class,
            'users' => [],
            'include_statut' => true,
        ]);
    }
}
