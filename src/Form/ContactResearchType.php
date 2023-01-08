<?php

namespace App\Form;

use App\Entity\Research;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactResearchType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $choiceMapper = $options['choice_mapper'];
        $categoryMapper = $options['category_mapper'];

        $builder
            ->add('email', null, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'Email',
                    'class' => 'form-control my-2 my-lg-0',
                ],
            ])
            ->add('city', null, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ville',
                    'class' => 'w-100 form-control my-2 my-lg-0',
                    'data-city-target' => 'input',
                ],
            ])
            ->add('zipCode', null, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Code postal',
                    'class' => 'w-100 form-control my-2 my-lg-0',
                ],
            ])
            ->add('surfaceMin', NumberType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Min',
                    'class' => 'form-control',
                ]
            ])
            ->add('surfaceMax', NumberType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Max',
                    'class' => 'form-control',
                ]
            ])
            ->add('priceMin', NumberType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Min',
                    'class' => 'form-control',
                ]
            ])
            ->add('priceMax', NumberType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Max',
                    'class' => 'form-control',
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
            ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Research::class,
            'choice_mapper' => null,
            'category_mapper' => null,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
