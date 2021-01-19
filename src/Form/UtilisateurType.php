<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', null, [
                'label' => 'Email :',
                'constraints' => [
                    new NotBlank(),
                    new Email()
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'label' => ' ',
                'invalid_message' => 'Les deux mots de passe doivent être identiques.',
                'required' => false,
                'help' => 'Pour modifier le mot de passe, entrez-le nouveau mot de passe deux fois',
                'first_options'  => ['label' => 'Mot de passe : ',
                    'attr' => [
                        'class' => 'form-control',
                    ],
                ],
                'second_options' => ['label' => 'Répétez le mot de passe :',
                    'attr' => [
                        'class' => 'form-control',
                    ],
                ],
                'mapped' => false,
            ])

            ->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
                $user = $event->getData();
                $form = $event->getForm();

                if ($user->getId() === null) {
                    $form
                        ->remove('password')
                        ->add('password', RepeatedType::class, [
                            'type' => PasswordType::class,
                            'label' => ' ',
                            'invalid_message' => 'Les deux mots de passe doivent être identiques.',
                            'required' => true,
                            'help' => 'Pour modifier le mot de passe, entrez-le nouveau mot de passe deux fois',
                            'first_options'  => ['label' => 'Mot de passe : ',
                                'attr' => [
                                    'class' => 'form-control',
                                ],
                            ],
                            'second_options' => ['label' => 'Répétez le mot de passe :',
                                'attr' => [
                                    'class' => 'form-control',
                                ],
                            ],
                            'mapped' => false,
                            'constraints' => [
                                new NotBlank(),
                                new Length([
                                    'min' => 6,
                                    'minMessage' => 'Votre mot de passe doit faire au moins {{ limit }} caractères',
                                    // max length allowed by Symfony for security reasons
                                    'max' => 4096,
                                ]),
                            ]
                        ])
                        ->add('nom', null, [
                            'label' => 'Nom :',
                            'constraints' => [
                                new NotBlank(),
                                new Regex([
                                    'pattern' => '/^[A-Za-z\é\è\ê\-]+$/',
                                    'match' => true,
                                ])
                            ]
                        ])
                        ->add('prenom', null, [
                            'label' => 'Prénom :',
                            'constraints' => [
                                new NotBlank(),
                                new Regex([
                                    'pattern' => '/^[A-Za-z\é\è\ê\-]+$/',
                                    'match' => true,
                                ])
                            ]
                        ])
                    ;
                }
            })
            ->add('telephone', null, [
                'label' => 'Téléphone :',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[0-9]{10}+/',
                        'match' => true,
                    ])
                ]
            ])

            ->add('nom', null, [
                'label' => 'Nom :',
                'constraints' => [
                    new NotBlank(),
                    new Regex([
                        'pattern' => '/^[A-Za-z\é\è\ê\-]+$/',
                        'match' => true,
                    ])
                ]
            ])

            ->add('prenom', null, [
                'label' => 'Prénom :',
                'constraints' => [
                    new NotBlank(),
                    new Regex([
                        'pattern' => '/^[A-Za-z\é\è\ê\-]+$/',
                        'match' => true,
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
