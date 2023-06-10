<?php

namespace App\Form;

use App\Entity\CarCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class CarCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => false,
                'attr' => array('class' => 'form-control-sm', 'style' => 'width: 465px')
            ])
            ->add('description', TextareaType::class, [
                'label' => false,
                'attr' => array('class' => 'form-control-sm', 'rows' => '3', 'style' => 'width: 465px')
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CarCategory::class,
        ]);
    }
}
