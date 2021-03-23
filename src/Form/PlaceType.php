<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Place;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class PlaceType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $cities = $this->entityManager->getRepository(City::class)->orderByName();

        $builder
            ->add('name', TextType::class, [
                'label'        => 'Nom',
                'label_attr'   => [
                    'class' => 'label',
                ],
                'attr'  => [
                    'class' => 'block w-full max-w-lg border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm',
                ],
            ])
            ->add('street', TextType::class, [
                'label'        => 'Rue',
                'label_attr'   => [
                    'class' => 'label',
                ],
                'attr'  => [
                    'class' => 'block w-full max-w-lg border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm',
                ],
            ])
            ->add('lat', IntegerType::class, [
                'label'        => 'Latitude',
                'label_attr'   => [
                    'class' => 'label',
                ],
                'attr'  => [
                    'class' => 'block w-full max-w-lg border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm',
                ],
            ])
            ->add('lon', IntegerType::class, [
                'label'        => 'Longitude',
                'label_attr'   => [
                    'class' => 'label',
                ],
                'attr'  => [
                    'class' => 'block w-full max-w-lg border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm',
                ],
            ])
            ->add('city', ChoiceType::class, [
                'choices'      => $cities,
                'choice_label' => 'name',
                'label'        => 'Ville',
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
            'data_class' => Place::class,
        ]);
    }
}
