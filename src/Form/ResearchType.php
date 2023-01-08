<?php

namespace App\Form;

use App\Entity\Research;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResearchType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $choiceMapper = $options['choice_mapper'];
        $categoryMapper = $options['category_mapper'];

        $builder
            ->add('search', null, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ce que vous cherchez',
                    'class' => 'form-control my-2 my-lg-0',
                ]
            ])
            ->add('city', null, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ville',
                    'class' => 'w-100 form-control my-2 my-lg-0',
                    'data-city-target' => 'input',
                ],
//                'choices' => $choiceMapper,
            ])
//            ->add('zipCode')
            ->add('surfaceMin', NumberType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Min',
                    'class' => 'form-control',
                    'data-range-target' => 'min',
                ]
            ])
            ->add('surfaceMax', NumberType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Max',
                    'class' => 'form-control',
                    'data-range-target' => 'max',
                ]
            ])
            ->add('priceMin', NumberType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Min',
                    'class' => 'form-control',
                    'data-range-target' => 'min',
                ]
            ])
            ->add('priceMax', NumberType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Max',
                    'class' => 'form-control',
                    'data-range-target' => 'max',
                ]
            ])
            ->add('type', ChoiceType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Type',
                    'class' => 'w-100 form-control my-2 my-lg-0',
                    'data-controller' => 'niceselect',
                    'data-niceselect-placeholder-value' => 'Type',
                    'data-niceselect-target' => 'select',
                ],
                'choices' => [
                    'Vente' => 'Vente',
                    'Location' => 'Location',
                ],
            ])
            ->add('category', ChoiceType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Catégories',
                    'class' => 'w-100 form-control my-2 my-lg-0',
                    'data-controller' => 'niceselect',
                    'data-niceselect-placeholder-value' => 'Catégories',
                    'data-niceselect-target' => 'select',
                ],
                'choice_label' => 'name',
                'choices' => $categoryMapper
            ])
            ->add('row', HiddenType::class, [
                'mapped' => false,
                'attr' => [
                    'data-range-target' => 'row',
                ]
            ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Research::class,
            'method' => 'GET',
            'csrf_protection' => false,
            'choice_mapper' => null,
            'category_mapper' => null,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
