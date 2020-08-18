<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\CompanyService;
use App\Entity\Service;
use App\Entity\User;
use App\Repository\CompanyServiceRepository;
use App\Repository\ServiceRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\File;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,[
                'attr'=>['class'=>'form-control']
            ])
            ->add('email', EmailType::class,[
                'attr'=>['class'=>'form-control']
            ])
            ->add('web_site', UrlType::class,[
                'attr'=>['class'=>'form-control']
            ])
            ->add('time_work_from', TextType::class,[
                'attr'=>['class'=>'form-control']
            ])
            ->add('time_work_to', TextType::class,[
                'attr'=>['class'=>'form-control']
            ])
            ->add('about_company', TextareaType::class,[
                'required' => false,
                'attr'=>['class'=>'form-control']
            ])
            ->add('director', EntityType::class,[
                'class'=>User::class,
                'attr'=>['class'=>'company_director form-control'],
                'query_builder'=>function(UserRepository $ur){
                    return $ur->findAuthUser();
                },
                'choice_label' => 'full_name',
            ])
            ->add('companyContacts', CollectionType::class,[
                'entry_type'=>CompanyContactType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'entry_options' => ['label' => false],
                'label'=>false
            ])
            ->add('address', TextType::class,[
                'required' => false,
                'attr'=>['class'=>'form-control']
            ])
            ->add('logo', FileType::class,[
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image document',
                    ])
                ],
            ])
            ->add('city', TextType::class,[
                'required' => false,
                'attr'=>['class'=>'form-control']
            ])
            ->add('street', TextType::class,[
                'required' => false,
                'attr'=>['class'=>'form-control']
            ])
            ->add('house', TextType::class,[
                'required' => false,
                'attr'=>['class'=>'form-control']
            ])
            ->add('country', TextType::class,[
                'required' => false,
                'attr'=>['class'=>'form-control']
            ])
            ->add('zip_code', TextType::class,[
                'required' => false,
                'attr'=>['class'=>'form-control']
            ])
            ->add('office', TextType::class,[
                'required' => false,
                'attr'=>['class'=>'form-control']
            ])
            ->add('is_delete_logo', HiddenType::class,[
                'required'=> false
            ])
            /*->add('companyServices', EntityType::class,[
                'class'=>Service::class,
                'attr'=>['class'=>'company_service form-control'],
                'query_builder'=>function(ServiceRepository $sr){
                    return $sr->findOwnerServices();
                },
                'choice_label' => 'service',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
