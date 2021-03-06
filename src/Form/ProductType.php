<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Vendor;
use App\Entity\Order;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,
            [
                'label' => "Phone name",
                'required' => true,
                'attr' =>
                [
                    'minlength' => 5,
                    'maxlength' => 30
                ]
            ])
            ->add('price', MoneyType::class,
            [
                'label' => 'Book Price',
                'required' => true,
                'currency' => 'USD'
            ])
            ->add('quantity', NumberType::class,
            [
                'label' => 'Quantity',
                'required' => true,
                'attr' =>
                [
                    'min' => 0,
                    'max' => 999
                ]
            ])
            ->add('status', ChoiceType::class,
            [
                'label' => "Status",
                'required' => true,
                'choices' =>
                [
                    'Available' => 'Available',
                    'NotAvailable' => 'Not Available'
                ]
            ])
            ->add('picture', FileType::class,
            [
                'label' => 'Product picture',
                'data_class' => null,
                'required' => is_null($builder->getData()->getPicture())
            ])
            ->add('orders', EntityType::class,
            [
                'label' => 'Product Order',
                'class' => Order::class,
                'required' => false,
                'choice_label' => 'location',
                'multiple' => true,
                'expanded' => false
            ])
            ->add('vendor', EntityType::class,
            [
                'label' => 'Product Vendor',
                'class' => Vendor::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false
            ])
            ->add('category', EntityType::class,
            [
                'label' => 'Product Category',
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
