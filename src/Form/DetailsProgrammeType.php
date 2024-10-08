<?php

namespace App\Form;

use App\Entity\DetailsProgramme;
use App\Entity\Exercice;
use App\Entity\Programme;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DetailsProgrammeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            /*->add('date')
            ->add('exercice', EntityType::class, [
                'class' => Exercice::class,
'choice_label' => 'id',
            ])
            ->add('programme', EntityType::class, [
                'class' => Programme::class,
'choice_label' => 'id',
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DetailsProgramme::class,
        ]);
    }
}
