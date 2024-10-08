<?php

namespace App\Form;

use App\Entity\Programme;
use App\Entity\TypeProgramme;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class ProgrammeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            /*->add('userId', EntityType::class, [
                'class' => User::class,
                'choices' => $options['users'],
                'choice_label' => function(User $user) {
                    return $user->getNom() . ' ' . $user->getPrenom();
                },
                'placeholder' => 'Select a user',
                'attr' => ['class' => 'form-control'],
            ])*/
            ->add('typeId', EntityType::class, [
                'class' => TypeProgramme::class,
                'choice_label' => 'libelle',
                'attr' => ['class' => 'form-control'],
            ]);
            //->add('dateDebut', DateType::class, [
              //  'widget' => 'single_text',
             //   'html5' => true,
              //  'attr' => ['class' => 'form-control'],
            //])
            //->add('dateFin', DateType::class, [
             //   'widget' => 'single_text',
              //  'html5' => true,
             //   'attr' => ['class' => 'form-control'],
            //])
       
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Programme::class,
            'users' => [],
            'affectations' => [],
        ]);
    }
}
