<?php

namespace App\Form;

use App\Entity\API;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class APIType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('description', TextareaType::class, [
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('url', TextType::class, [
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('header_tokken', TextType::class , [
                "required" =>false,
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('methode', ChoiceType::class, [
                "attr" => [
                    "class" => "form-control"
                ],
                'choices'  => [
                    'GET' => 1,
                    'POST' => 2,
                    'PUT' => 3,
                    'DELETE' => 4,
                    'UPDATE' => 5
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => API::class,
        ]);
    }
}
