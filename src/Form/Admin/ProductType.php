<?php

namespace App\Form\Admin;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control input-default'
                ],
                'label' => 'Nom'
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control input-default'
                ]
            ])->add('metaDescription', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control input-default',
                    'maxlength' => "230"
                ]
            ])
            ->add('price', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control input-default'
                ],
                'label' => 'Prix'
            ])
            ->add('images', FileType::class, [
                'mapped' => false,
                'required' => false,
                'multiple' => true,
                'attr' => [
                    'is' => 'drop-files'
                ],
                'constraints' => [
                    new All([
                        new File([
                            'maxSize' => '2M',
                            'mimeTypes' => [
                                'image/jpeg',
                                'image/png',
                            ],
                            'mimeTypesMessage' => 'Image en png jpeg autoris?? seulement !',
                        ])
                    ])
                ],
            ])
            ->add('quantity', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control input-default'
                ],
                'label' => 'Quantit??'
            ])
            ->add('isPublished', CheckboxType::class,[
                'label' => 'Publier',
                'required' => false
            ])
            ->add('isSpecialOffer', CheckboxType::class,[
                'label' => 'Offre sp??cial',
                'required' => false
            ])
            ->add('percentOffer', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control input-default'
                ],
                'label' => 'Pourcentage de l\'offre',
                'required' => false
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'multiple' => true,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Cat??gories'
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
