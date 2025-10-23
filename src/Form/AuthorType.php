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
            ->add('email', EmailType::class);

        // Ajouter nbBooks seulement en édition (lecture seule)
        if ($options['is_edit']) {
            $builder->add('nbBooks', IntegerType::class, [
                'label' => 'Nombre de livres',
                'disabled' => true,
            ]);
        }

        // Bouton dynamique : label Save ou Update selon is_edit
        $builder->add('save', SubmitType::class, [
            'label' => $options['is_edit'] ? 'Update' : 'Save',
            'attr' => ['class' => 'btn-submit mt-2']
        ])

        ->add('min', IntegerType::class, [
                'required' => false,
                'label' => 'Min Number',
                'attr' => [
                    'placeholder' => 'Min',
                    'style' => 'width:100px; margin-right:10px;'
                ],
            ])
            ->add('max', IntegerType::class, [
                'required' => false,
                'label' => 'Max Number',
                'attr' => [
                    'placeholder' => 'Max',
                    'style' => 'width:100px; margin-right:10px;'
                ],
            ]);


        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
            'is_edit' => false,
        ]);
    }
}
