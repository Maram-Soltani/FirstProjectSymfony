<?php

namespace App\Form;

use App\Entity\Author;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
{
    $builder
        ->add('username', TextType::class)
        ->add('email', EmailType::class)
        ->add('save', SubmitType::class, [
            'label' => 'Save',
            'attr' => ['class' => 'btn btn-primary mt-2']
        ]);

    // 👉 On ajoute nbBooks SEULEMENT si on est en mode édition
    if ($options['is_edit']) {
        $builder->add('nbBooks', IntegerType::class, [
            'label' => 'Nombre de livres',
            'disabled' => true, // en lecture seule
        ]);
    }
}


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
            'is_edit' => false, 
        ]);
    }
}
