<?php

namespace App\Form;

use App\Entity\Absence;
use App\Repository\StudentRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Student;
use Vich\UploaderBundle\Form\Type\VichFileType;

class AbsenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lateTime', IntegerType::class, [
                'label' => 'Temps de retards (minutes)',
                'required' => false
            ])
            ->add('reason', TextareaType::class, [
                'label' => 'Raison',
                'required' => false
            ])
            ->add('isValid', ChoiceType::class, [
                'label' => 'Validé',
                'choices' => [
                    'Justifié' => true,
                    'Non Justifié' => false,
                    'A justifier' => null
                ],
                'expanded' => true,
                'multiple' => false,
                'required' => true
            ])
            ->add('proofFile', VichFileType::class, [
                'label' => 'Justificatif',
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'Supprimer le justificatif existant',
                'download_label' => 'Télécharger le justificatif existant',
                'download_uri' => true,
                'asset_helper' => true,
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
