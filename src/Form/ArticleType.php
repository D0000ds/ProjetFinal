<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Origine;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('poids', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'formLittle',
                    'placeholder' => '  Poids (en gramme)'
                ],
            ])
            ->add('libelle', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form',
                    'placeholder' => 'Libelle'
                ],
            ])
            ->add('description' , TextareaType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'formTextArea',
                    'placeholder' => 'Description'
                ],
            ])
            ->add('marque', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form',
                    'placeholder' => 'Marque'
                ],
            ])
            ->add('prix', IntegerType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form',
                    'placeholder' => 'Prix'
                ],
            ])
            ->add('image', FileType::class, [
                'label' => false,
                'multiple' => false,
            ])
            ->add('conservation', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'formLittle',
                    'placeholder' => 'Temps de conservation'
                ],
            ])
            ->add('qte', IntegerType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form',
                    'placeholder' => 'Quantité'
                ],
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'attr' => [
                    'class' => 'formLittle',
                ],
            ])
            ->add('origine', EntityType::class, [
                'class' => Origine::class,
                'attr' => [
                    'class' => 'formLittle',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
