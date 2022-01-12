<?php

namespace App\Controller;

use App\Entity\Absence;
use App\Entity\Student;
use App\Form\AbsenceType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AbsenceController extends AbstractController
{


    #[Route('/absence/{id}/edit', name: 'absence_edit')]
    #[IsGranted('ROLE_ADMIN')]
    public function editAbsence(Absence $absence, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(AbsenceType::class, $absence);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($absence);
            $manager->flush();
            $this->addFlash('success', "L'absence a été correctement été modifié !");
            return $this->redirectToRoute('absence_edit', [
                'id' => $absence->getId()
            ]);
        }

        return $this->render('absence/editAbsence.html.twig', [
            'form' => $form->createView(),
            'absence' => $absence
        ]);
    }

    #[Route('/absence/{id}', name: 'absence_show')]
    #[IsGranted('ROLE_YEAR_RESPONSIBLE')]
    public function showAbsence(Absence $absence, Request $request, EntityManagerInterface $manager): Response
    {

        return $this->render('absence/showAbsence.html.twig', [
            'absence' => $absence
        ]);
    }

    #[Route('/student/{id}/absences', name: 'student_absences_list')]
    #[IsGranted('ROLE_YEAR_RESPONSIBLE')]
    public function listAbsencesStudent(Student $student): Response
    {

        return $this->render('absence/listAbsencesStudent.html.twig', [
            'student' => $student
        ]);
    }


}
