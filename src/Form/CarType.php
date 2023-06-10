<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\CarCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nbSeats', null, [
                'label' => false,
                'attr' => array('class' => 'form-control-sm', 'style' => 'width: 465px')
            ])
            ->add('nbDoors', null, [
                'label' => false,
                'attr' => array('class' => 'form-control-sm', 'style' => 'width: 465px')
            ])
            ->add('name', null, [
                'label' => false,
                'attr' => array('class' => 'form-control-sm', 'style' => 'width: 465px')
            ])
            ->add('cost', null, [
                'label' => false,
                'attr' => array('class' => 'form-control-sm', 'style' => 'width: 465px')
            ])->add(
                'category',
                EntityType::class,
                [
                    'class' => CarCategory::class,
                    'choice_label' => 'name',
                    'label' => false,
                    'required' => false,
                    'multiple' => false,
                    'attr' => array('class' => 'form-control-sm form-select form-select-sm', 'style' => 'width: 465px')
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
