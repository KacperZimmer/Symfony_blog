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

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CommentType.
 *
 * Form type for creating or editing a comment.
 */
class CommentType extends AbstractType
{
    /**
     * Builds the form for creating or editing a comment.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options An array of options for building the form
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'form.label.email',
                'attr' => ['placeholder' => 'form.placeholder.email'],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                ],
            ])
            ->add('nick', TextType::class, [
                'label' => 'form.label.nick',
                'attr' => ['placeholder' => 'form.placeholder.nick'],
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
                        'max' => 500,
                    ]),
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'button.add_comment',
            ]);
    }

    /**
     * Configures the options for this form.
     *
     * @param OptionsResolver $resolver The resolver used to define the options
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
