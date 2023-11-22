<?php

namespace App\Form;

use App\Entity\Contacts;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name')
            ->add('FirstName')
            ->add('password')
            ->add('Address')
            ->add('ZipCode')
            ->add('Town')
            ->add('Email')
            ->add('Phone')
            ->add('role')
            ->add('Objectif')
            ->add('Id')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contacts::class,
        ]);
    }
}
