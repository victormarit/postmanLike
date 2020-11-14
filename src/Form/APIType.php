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
                "label" => "Nom",
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
            ->add('header', TextareaType::class , [
                "required" =>false,
                "attr" => [
                    "class" => "form-control",
                    'placeholder' => "key1: value, key2: value ..."
                ]
            ])
            ->add('body', TextareaType::class , [
                "required" =>false,
                "attr" => [
                    "class" => "form-control",
                    'placeholder' => "key1: value,\nkey2: value ..."
                ]
            ])
            ->add('methode', ChoiceType::class, [
                "attr" => [
                    "class" => "form-control"
                ],
                "label" => 'Méthode',
                'choices'  => [
                    'GET' => 'GET',
                    'POST' => 'POST',
                    'PUT' => 'PUT',
                    'DELETE' => 'DELETE',
                    'UPDATE' => 'UPDATE'
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
