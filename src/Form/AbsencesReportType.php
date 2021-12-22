<?php

namespace App\Form;

use App\Entity\Absence;
use App\Entity\AbsencesReport;
use App\Repository\TeacherRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Teacher;

class AbsencesReportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
            ->add('absences', CollectionType::class, [
                'entry_type' => AbsenceType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => 'Absence',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AbsencesReport::class,
        ]);
    }
}
