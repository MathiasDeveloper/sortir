<?php

namespace App\Form;

use App\Entity\Site;
use App\Entity\Participant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $sites = $this->entityManager->getRepository(Site::class)->orderByName();
        $builder
            ->add('email', EmailType::class, [
                'label'        => 'Email',
                'label_attr'   => [
                    'class' => 'label',
                ],
                'attr'  => [
                    'class' => 'block w-full max-w-lg border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm',
                ],
            ])
            ->add('username', TextType::class, [
                'label'        => 'Pseudo',
                'label_attr'   => [
                    'class' => 'label',
                ],
                'attr'  => [
                    'class' => 'block w-full max-w-lg border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm',
                ],
            ])
            ->add('firstname', TextType::class, [
                'label'        => 'Prénom',
                'label_attr'   => [
                    'class' => 'label',
                ],
                'attr'  => [
                    'class' => 'block w-full max-w-lg border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm',
                ],
            ])
            ->add('lastname', TextType::class, [
                'label'        => 'Nom',
                'label_attr'   => [
                    'class' => 'label',
                ],
                'attr'  => [
                    'class' => 'block w-full max-w-lg border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm',
                ],
            ])
            ->add('password', RepeatedType::class, [
                'type'            => PasswordType::class,
                'first_options'   => [
                    'label'        => 'Mot de passe',
                    'label_attr'   => [
                        'class' => 'label',
                    ],
                    'attr'  => [
                        'class' => 'block w-full max-w-lg border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm',
                    ],
                ],
                'second_options'  => [
                    'label'        => 'Confirmer le mot de passe',
                    'label_attr'   => [
                        'class' => 'label',
                    ],
                    'attr'  => [
                        'class' => 'block w-full max-w-lg border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm',
                    ],
                ],
                'invalid_message' => 'Your passwords do not match!',
            ])
            ->add('site', ChoiceType::class, [
                'choices'      => $sites,
                'choice_label' => 'name',
                'label'        => 'Nom',
                'label_attr'   => [
                    'class' => 'label',
                ],
                'attr'  => [
                    'class' => 'block w-full max-w-lg border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
