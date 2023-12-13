<?php

namespace App\Form;

use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form',
                    'placeholder' => 'Libelle'
                ],
            ])
            ->add('image', FileType::class, [
                'label' => false,
                'multiple' => false,
                'data_class' => null,
            ])
            ->add('code', ChoiceType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form',
                    'placeholder' => 'Libelle'
                ],
                'choices' => [
                    'Cafées Moulues' => 'CAFÉES MOULUES',
                    'Cafés en Grains' => 'CAFÉS EN GRAINS',
                    'Cafés Dossetes' => 'CAFÉS DOSSETES',
                    'Cafés Capsules' => 'CAFÉS CAPSULES',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
        ]);
    }
}
