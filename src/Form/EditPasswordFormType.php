<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class EditPasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'required' => true,
                'label' => false,
                'attr' => [
                    'class' => 'form', 
                    'placeholder' => 'Mot de passe'
                ],
            ])
            ->add('newPassword', RepeatedType::class, [
                'mapped' => false,
                'type' => PasswordType::class,
                'invalid_message' => 'Les mot de passes doivent correspondre.',
                'options' => ['attr' => ['class' => 'form', 'placeholder' => 'Nouveau Mot de passe']],
                'required' => true,
                'first_options'  => ['label' => false],
                'second_options' => ['label' => false],
                'constraints' => [
                    new Regex('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{8,}$/', 
                    "Votre mot de passe doit comporter au moins 8 caractères avec 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère special")
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
