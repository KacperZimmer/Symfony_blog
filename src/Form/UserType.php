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

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UserType.
 *
 * Form type for creating or editing a user.
 */
class UserType extends AbstractType
{
    /**
     * Builds the form for creating or editing a user.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options An array of options for building the form
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'form.label.email',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'form.label.plainPassword',
                'required' => false,
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Assert\Length([
                        'min' => 6,
                    ]),
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'form.button.save',
                'attr' => ['class' => 'btn btn-primary mt-3'],
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
            'data_class' => User::class,
        ]);
    }
}
