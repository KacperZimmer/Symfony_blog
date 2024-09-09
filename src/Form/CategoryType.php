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
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CategoryType.
 *
 * Form type for creating or editing a category.
 */
class CategoryType extends AbstractType
{
    /**
     * Builds the form for creating or editing a category.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options An array of options for building the form
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'form.label.name',
                'attr' => [
                    'placeholder' => 'form.placeholder.name',
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length([
                        'max' => 50,
                    ]),
                ],
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
            'data_class' => Category::class,
        ]);
    }
}
