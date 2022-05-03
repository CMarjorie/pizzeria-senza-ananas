<?php

namespace App\Form;

use App\Entity\Extra;
use App\Entity\PizzaDetail;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PizzaDetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('product', HiddenType::class, [
            //     'label' => 'pizza'
            // ])
            ->add('extra', EntityType::class, [
                'class' => Extra::class,
                'label' => 'Suppléments ',
                'multiple' => true,
                'expanded' => true,
                'attr' => ['class' => 'form-check d-flex justify-content-between']
            ])
            //  ->add('price', HiddenType::class)
            ->add('Ajouter', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-dark btn-cart mt-4',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PizzaDetail::class,
        ]);
    }
}
