<?php

/**
 * This file is part of the [Blog app] project.
 *
 * (c) [2024] [Kacper Zimmer]
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 *
 * For more information, please view the LICENSE file that was
 * distributed with this source code.
 */

namespace App\Form;

use App\Entity\Category;
use App\Entity\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class PostType
 *
 * Form type for creating or editing a post.
 */
class PostType extends AbstractType
{
    /**
     * Builds the form for creating or editing a post.
     *
     * @param FormBuilderInterface $builder the form builder
     * @param array                $options an array of options for building the form
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'form.label.title',
                'attr' => ['placeholder' => 'form.placeholder.title'],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length([
                        'max' => 50,
                    ]),
                ],
            ])
            ->add('content', TextareaType::class, [
                'label' => 'form.label.content',
                'attr' => ['placeholder' => 'form.placeholder.content'],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length([
                        'max' => 2000,
                    ]),
                ],
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'label' => 'form.label.categories',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'form.button.save',
            ]);
    }

    /**
     * Configures the options for this form.
     *
     * @param OptionsResolver $resolver the resolver used to define the options
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
