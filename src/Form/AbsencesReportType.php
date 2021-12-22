<?php

namespace App\Form;

use App\Repository\TeacherRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Teacher;

class AbsencesReportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du rapport',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Nom du rapport',
                ],
            ])
            ->add('courseDuration', IntegerType::class,[
                'label' => 'Durée du cours (minutes)',
            ])
            ->add('teacher', EntityType::class, [
                'class' => Teacher::class,
                'choice_label' => 'fullname',
                'placeholder' => 'Choose a teacher',
                'query_builder' => function (TeacherRepository $repository) {
                    return $repository->createQueryBuilder('t')
                        ->orderBy('t.lastName', 'ASC');
                },
            ])
        ->add('students', ChoiceType::class, [
            'label' => 'Élèves',
            'mapped' => false,
            'multiple' => true,
            'expanded' => true,
            'required' => false,
            'choices' => $options['students'],
            'choice_label' => function ($choice) {
                return $choice->getFullname();
            },
            'data' => $options['studentsSelected'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'students' => [],
            'studentsSelected' => []
        ]);
    }
}
