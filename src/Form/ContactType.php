<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom', null, [
            'label' => 'Nom:',
            'constraints' => [
                new NotBlank(),
                new Regex([
                    'pattern' => '/^[A-Za-z\é\è\ê\-]+$/',
                    'match' => true,
                ])
            ],
            'attr' => [
                'class' => 'form-control',
            ],
        ])

        ->add('prenom', null, [
            'label' => 'Prénom:',
            'constraints' => [
                new NotBlank(),
                new Regex([
                    'pattern' => '/^[A-Za-z\é\è\ê\-]+$/',
                    'match' => true,
                ])
            ],
            'attr' => [
                'class' => 'form-control',
            ],
        ])

        ->add('telephone', null, [
            'label' => 'Téléphone:',
            'constraints' => [
                new Regex([
                    'pattern' => '/^[0-9]{10}+/',
                    'match' => true,
                ])
            ],
            'attr' => [
                'class' => 'form-control',
            ],
            'required' => false,
        ])

        ->add('email', null, [
            'label' => 'E-mail:',
            'constraints' => [
                new NotBlank(),
                new Email(),
            ],
            'attr' => [
                'class' => 'form-control',
            ],
        ])

        ->add('subject', ChoiceType::class, [
            'label' => 'Votre demande concerne:',
            'choices' => [
                'Une demande d\'information' => 'Une demande d\'information',
                'Un suivi en nutrition' => 'Un suivi en nutrition',
                'Un suivi sportif' => 'Un suivi sportif',
                'Autre demande' => 'Autre demande',
            ],
            'attr' => [
                'class' => 'form-control',
            ],
        ])

        ->add('message', TextareaType::class, [
            'label' => 'Message:',
            'attr' => [
                'class' => 'form-control',
            ]
        ])

        ->add('checkbox', CheckboxType::class, [
            'attr' => [
                'class' => 'd-inline',
            ]
        ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
