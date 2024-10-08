<?php

namespace App\Form;

use App\Entity\Banniere;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

class BanniereType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('textButton')
            ->add('imageBanniere', FileType::class, [
                'label' => 'Upload',
                'attr' => [
                    'class' => 'form-control',
                ],
                'multiple' => true,
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez télécharger une image.',
                    ]),
                    // Ajoutez d'autres contraintes si nécessaire, comme la taille maximale, le type de fichier, etc.
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Banniere::class,
        ]);
    }
}
