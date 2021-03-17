<?php

namespace App\Form;

use App\Entity\Place;
use App\Entity\Trip;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
                    'label' => 'Name'
                ]
            )
            ->add(
                'begin_date',
                DateTimeType::class,
                [
                    'label' => 'Begin date'
                ]
            )
            ->add(
                'end_date',
                DateType::class,
                [
                    'label' => 'End date'
                ]
            )
            ->add(
                'duration',
                TimeType::class,
                [
                    'label' => 'Duration'
                ]
            )
            ->add('max_subscriptions', IntegerType::class)
            ->add('description', TextType::class)
            ->add(
                'save',
                SubmitType::class
            )
            ->add(
                'send',
                SubmitType::class
            )
            ->add(
                'place',
                ChoiceType::class,
                [
                    'choices' => $this->getPlaceRepository()->findAll(),
                    'choice_label' => 'name',
                ]
            )
            ->add('cancel', SubmitType::class);
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
                'data_class' => Trip::class
            ]
        );
    }
}


