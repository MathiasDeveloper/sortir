<?php

namespace App\Form;

use App\Entity\Participant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, $this->getTextInputOptions('Pseudo'))
            ->add('email', EmailType::class, $this->getTextInputOptions('E-mail'))
            // ->add('photoUrl', TextType::class, $this->getTextInputOptions('Photo'))
            ->add('photoUrl', FileType::class, [
                'label' => 'Photo',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize'   => '2048k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid JPG/PNG document',
                    ]),
                ],
                'label_attr'  => [
                    'class' => 'label sm:mt-px sm:pt-2',
                ],
                'attr'  => [
                    'class' => 'hidden',
                ],
            ])
            ->add('firstname', TextType::class, $this->getTextInputOptions('Prénom'))
            ->add('lastname', TextType::class, $this->getTextInputOptions('Nom'))
            ->add('phone', TelType::class, $this->getTextInputOptions('Téléphone', false))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }

    public function getTextInputOptions(string $label, bool $required = true): array
    {
        return [
            'label'       => $label,
            'label_attr'  => [
                'class' => 'label sm:mt-px sm:pt-2',
            ],
            'attr'  => [
                'class' => 'input-text',
            ],
            'required' => $required,
        ];
    }
}
