<?php

namespace App\Form;

use App\Entity\Participant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label'       => 'E-mail',
                'label_attr'  => [
                    'class' => 'block text-sm font-medium text-gray-700',
                ],
                'attr'  => [
                    'class' => 'input-text',
                ],
            ])
            ->add('password', PasswordType::class, [
                'label'       => 'Mot de passe',
                'label_attr'  => [
                    'class' => 'label',
                ],
                'attr'  => [
                    'class' => 'input-text',
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
