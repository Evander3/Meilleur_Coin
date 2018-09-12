<?php

namespace AppBundle\Form;

use AppBundle\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Ad;

class AdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        return $builder
            ->add('title', TextType::class, [
                'required'=>false,
                'label'=>'AdForm.title',
            ])
            ->add('description', TextareaType::class, [
                'label'=>'AdForm.description',
            ])
            ->add('city', TextType::class, [
                'label'=>'AdForm.city',
            ])
            ->add('zip', IntegerType::class, [
                'label'=>'AdForm.zip',
            ])
            ->add('price', MoneyType ::class, [
                'label'=>'AdForm.price',
            ])
            ->add('category', EntityType::class, [
                'class'=>Category::class,
                'choice_label'=>'NameCapitalized',
                'label'=>'AdForm.category',
                'placeholder'=>'AdForm.placeholder',
            ])
            ->getForm()
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class
        ]);
    }
}
