<?php

namespace App\Form;

use App\Entity\Absence;
use App\Repository\StudentRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Student;

class AbsenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lateTime', IntegerType::class, [
                'label' => 'Temps de retards (secondes)',
                'required' => false
            ])
            ->add('student', EntityType::class, [
                'class' => Student::class,
                'label' => 'Élève',
                'placeholder' => 'Choisissez un élève',
                'required' => true,
                'data' => $options['students']

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'students' => [],
        ]);
    }
}
