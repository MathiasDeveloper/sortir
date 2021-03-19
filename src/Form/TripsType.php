<?php

namespace App\Form;

use App\Entity\Site;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class TripsType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $allOption = new Site();
        $allOption->setName('Tous');
        $sites = $this->entityManager->getRepository(Site::class)->orderByName();
        array_unshift($sites, $allOption);

        $builder
            ->add('site', ChoiceType::class, [
                'choices'      => $sites,
                'choice_label' => 'name',
                'label'        => 'Site',
                'label_attr'   => [
                    'class' => 'label',
                ],
                'attr'  => [
                    'class' => 'input-select',
                ],
            ])
            ->add('search', SearchType::class, [
                'label'        => 'Le nom de la sortie contient',
                'label_attr'   => [
                    'class' => 'label',
                ],
                'attr'  => [
                    'class' => 'input-text',
                ],
                'required' => false,
            ])
            ->add('begin_date', DateType::class, [
                'widget'       => 'single_text',
                'label'        => 'Date de début',
                'label_attr'   => [
                    'class' => 'label',
                ],
                'attr'  => [
                    'class' => 'input-text',
                ],
                'required' => false,
            ])
            ->add('end_date', DateType::class, [
                'widget'       => 'single_text',
                'label'        => 'Date de fin',
                'label_attr'   => [
                    'class' => 'label',
                ],
                'attr'  => [
                    'class' => 'input-text',
                ],
                'required' => false,
            ])
            ->add('self_organisor', CheckboxType::class, [
                'label'        => "Sorties dont je suis l'organisateur-ice",
                'label_attr'   => [
                    'class' => 'label-checkbox',
                ],
                'attr'  => [
                    'class' => 'input-checkbox',
                ],
                'required' => false,
            ])
            ->add('self_subscription', CheckboxType::class, [
                'label'        => 'Sorties où je suis inscrit-e',
                'label_attr'   => [
                    'class' => 'label-checkbox',
                ],
                'attr'  => [
                    'class' => 'input-checkbox',
                ],
                'required' => false,
            ])
            ->add('self_unsubscription', CheckboxType::class, [
                'label'        => 'Sorties où je ne suis pas inscrit-e',
                'label_attr'   => [
                    'class' => 'label-checkbox',
                ],
                'attr'  => [
                    'class' => 'input-checkbox',
                ],
                'required' => false,
            ])
            ->add('end_trips', CheckboxType::class, [
                'label'        => 'Sorties qui sont passées',
                'label_attr'   => [
                    'class' => 'label-checkbox',
                ],
                'attr'  => [
                    'class' => 'input-checkbox',
                ],
                'required' => false,
            ])
        ;
    }
}
