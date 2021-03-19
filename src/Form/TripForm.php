<?php

namespace App\Form;

use App\Entity\Trip;
use App\Entity\Place;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TripForm extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'label'        => 'Nom',
                    'label_attr'   => [
                        'class' => 'label',
                    ],
                    'attr'  => [
                        'class' => 'input-text',
                    ],
                ]
            )
            ->add(
                'begin_date',
                DateTimeType::class,
                [
                    'widget'       => 'single_text',
                    'label'        => 'Date de la sortie',
                    'label_attr'   => [
                        'class' => 'label',
                    ],
                    'attr'  => [
                        'class' => 'input-datetime',
                    ],
                ]
            )
            ->add(
                'end_date',
                DateType::class,
                [
                    'widget'       => 'single_text',
                    'label'        => 'Date de la clôture',
                    'label_attr'   => [
                        'class' => 'label',
                    ],
                    'attr'  => [
                        'class' => 'input-datetime',
                    ],
                ]
            )
            ->add(
                'duration',
                TimeType::class,
                [
                    'widget'       => 'single_text',
                    'label'        => 'Durée',
                    'label_attr'   => [
                        'class' => 'label',
                    ],
                    'attr'  => [
                        'class' => 'input-text',
                    ],
                ]
            )
            ->add('max_subscriptions', IntegerType::class, [
                'label'        => 'Inscriptions maximum',
                'label_attr'   => [
                    'class' => 'label',
                ],
                'attr'  => [
                    'class' => 'input-text',
                ],
            ])
            ->add('description', TextareaType::class, [
                'label'        => 'Description',
                'label_attr'   => [
                    'class' => 'label',
                ],
                'attr'  => [
                    'class' => 'input-text',
                ],
            ])
            ->add(
                'save',
                SubmitType::class,
                [
                    'label'             => 'Enregistrer',
                    'attr'              => [
                        'class' => 'button',
                    ],
                ]
            )
            ->add(
                'send',
                SubmitType::class,
                [
                    'label'             => 'Publier',
                    'attr'              => [
                        'class' => 'button',
                    ],
                ]
            )
            ->add(
                'delete',
                SubmitType::class,
                [
                    'label'             => 'Supprimer',
                    'attr'              => [
                        'class' => 'button',
                    ],
                ]
            )
            ->add(
                'place',
                ChoiceType::class,
                [
                    'choices'      => $this->getPlaceRepository()->findAll(),
                    'choice_label' => 'name',
                    'label_attr'   => [
                        'class' => 'label',
                    ],
                    'attr'  => [
                        'class' => 'input-select',
                    ],
                ]
            )
            ->add('cancel', SubmitType::class, [
                'label'             => 'Annuler',
                'attr'              => [
                    'class' => 'button',
                ],
            ]);
    }

    /**
     * @return ObjectRepository
     */
    private function getPlaceRepository(): ObjectRepository
    {
        return $this->entityManager->getRepository(Place::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => Trip::class,
            ]
        );
    }
}
