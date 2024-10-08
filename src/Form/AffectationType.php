<?php

namespace App\Form;

use App\Entity\Affectation;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class AffectationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        
        ;

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
            'data_class' => Affectation::class,
            'include_statut' => true,
        ]);
    }
}
