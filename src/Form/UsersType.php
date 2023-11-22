<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir votre nom d\'utilisateur.',
                    ]),
                ],
            ])
            ->add('firstName', TextType::class, [
                'label' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir votre prénom d\'utilisateur.',
                    ]),
                ],
            ])

            ->add('address', TextType::class, [
                'label' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir votre adresse.',
                    ]),
                    new Length([
                        'min' => 5,
                        'max' => 30,
                        'exactMessage' => 'Votre adresse doit contenir entre 5 et 30 caractères.',
                    ])
                ],
            ])

            ->add('zipCode', NumberType::class, [
                'label' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir votre code postal.']),
                    new Length([
                        'min' => 5,
                        'max' => 5,
                        'exactMessage' => 'Votre code postal doit contenir exactement 5 chiffres.',
                    ]),
                ],
            ])

            ->add('town', TextType::class, [
                'label' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir votre ville de résidence.',
                    ]),
                ],
            ])

            ->add('email', EmailType::class, [
                'label' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir votre adresse e-mail.']),
                    new Email(['message' => 'Adresse e-mail invalide.']),
                ],
            ])

            ->add('phone', NumberType::class, [
                'label' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir votre téléphone.',
                    ]),
                ],
            ])

            ->add('plainPassword', PasswordType::class, [
                'label' => 'Mot de passe',
                'mapped' => false, // This field is not mapped to the entity
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un mot de passe.',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit comporter au moins 6 caractères.',
                        'max' => 20,
                    ]),
                ],
            ])

            ->add('role', ChoiceType::class, [
                'label' => 'form.label.role',
                'choices' => [
                    'administrateur' => 'ROLE_ADMIN',
                    'utilisateur' => 'ROLE_USER',
                ],
                'choice_translation_domain' => 'user', // Déplacez cette option ici, en dehors du tableau 'choices'
                'multiple'  => true,
                'expanded' => true,
                'required' => true,
            ])

            ->add('Objectif', TextType::class, [
                'label' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir l\'objectif du rendez-vous.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
