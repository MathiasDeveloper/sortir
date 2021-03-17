<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UpdatePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('current_password', PasswordType::class, [
                'label'       => 'Mot de passe actuel',
                'label_attr'  => [
                    'class' => 'label sm:mt-px sm:pt-2',
                ],
                'attr'  => [
                    'class' => 'input-text',
                ],
            ])
            ->add('new_password', PasswordType::class, [
                'label'       => 'Nouveau mot de passe',
                'label_attr'  => [
                    'class' => 'label sm:mt-px sm:pt-2',
                ],
                'attr'  => [
                    'class' => 'input-text',
                ],
            ])
            ->add('new_confirm_password', PasswordType::class, [
                'label'       => 'Confirmer le nouveau mot de passe',
                'label_attr'  => [
                    'class' => 'label sm:mt-px sm:pt-2',
                ],
                'attr'  => [
                    'class' => 'input-text',
                ],
            ])
        ;
    }
}
