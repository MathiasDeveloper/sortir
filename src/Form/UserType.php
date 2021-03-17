<?php

namespace App\Form;

use App\Entity\Participant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, $this->getTextInputOptions('Pseudo'))
            ->add('email', EmailType::class, $this->getTextInputOptions('E-mail'))
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
