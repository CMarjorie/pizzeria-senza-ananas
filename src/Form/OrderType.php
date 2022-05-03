<?php

namespace App\Form;

use App\Entity\Order;
use App\Entity\PaymentMode;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //->add('amount')
            //->add('date')
            ->add('lastName')
            ->add('firstName')
            ->add('adressLine1')
            ->add('adressLine2')
            ->add('postalCode')
            ->add('city')
            ->add('phoneNumber')
            ->add('email')
            ->add('paymentMode', EntityType::class, [
                'class' => PaymentMode::class,
                'choice_label' => 'name',
            ])
            ->add('Commander', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
