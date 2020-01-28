<?php

namespace App\Form;

use App\Entity\Blog;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("name", TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                "label" => "Full Name"
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('blog', BlogType::class)
            ->add('plainPassword', RepeatedType::class, [
                "type" => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                "required" => true,
                "first_options" => [
                    'label' => 'Password',
                    'attr' => [
                        'class' => 'form-control'
                    ],
                ],
                "second_options" => [
                    'label' => 'Repeat Password',
                    'attr' => [
                        'class' => 'form-control'
                    ],
                ],
            ])
            ->add("termsAgreed", CheckboxType::class, [
                "mapped" => false,
                "constraints" => new IsTrue(),
                "label" => "I agree to the terms of service",
                'attr' => [
                    'class' => 'form-check-input'
                ],
            ])
            ->add('Register', SubmitType::class, [
                "attr" => [
                    "class" => "btn btn-outline-success mt-3 btn-lg"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
