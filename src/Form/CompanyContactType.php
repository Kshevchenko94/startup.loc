<?php

namespace App\Form;

use App\Entity\CompanyContact;
use App\Entity\ContactType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contact', TextType::class,[
                'attr'=>['class'=>'form-control']
            ])
            ->add('contact_type', EntityType::class,[
                'class' => ContactType::class,
                'choice_label' => 'name',
                'placeholder' => 'Select your type contact',
                'attr'=>['class'=>'form-control']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CompanyContact::class,
        ]);
    }
}
