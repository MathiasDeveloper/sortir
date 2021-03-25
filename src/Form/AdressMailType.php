<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class AdressMailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'emailAdress',
                EmailType::class,
                [
                    'label_attr' => [
                        'class' => 'label sm:mt-px sm:pt-2',
                    ],
                    'attr' => [
                        'class' => 'input-text',
                        'placeholder' => 'example@gmail.com',
                    ],
                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                [
                    'attr' => [
                        'class' => 'mt-3 flex justify-center w-full px-4 py-2 text-sm font-medium text-white
                        bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700
                         focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500',
                    ],
                ]
            );
    }
}
