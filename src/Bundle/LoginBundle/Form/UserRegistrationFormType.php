<?php

namespace MMC\User\Bundle\LoginBundle\Form;

use MMC\User\Bundle\LoginBundle\Entity\LoginFormAuthenticator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserRegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('login', TextType::class)
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LoginFormAuthenticator::class,
            'validation_groups' => ['Default', 'Registration'],
        ]);
    }
}
