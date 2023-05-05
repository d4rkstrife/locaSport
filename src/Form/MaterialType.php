<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Material;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaterialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label' => "material.name"
            ])
            ->add('description',TextType::class,[
        'label' => "material.description"
    ])
            ->add('price',TextType::class,[
        'label' => "material.price"
    ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,

                // uses the User.username property as the visible option string
                'choice_label' => 'name',
                'label' => 'app.category',
                'mapped' => false,
            ])
            ->add('materialPicture', FileType::class, [
                'label' => 'Article Image (Png or jpeg)',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the file
                // every time you edit the Product details
                'required' => false,
                'multiple' => true,
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Material::class,
        ]);
    }
}
