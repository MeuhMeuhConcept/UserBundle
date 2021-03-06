<?php

namespace MMC\User\Bundle\ResourceFormBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;

class EmailFormType extends ResourceFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('resource', EmailType::class)
        ;
    }
}
