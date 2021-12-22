<?php

namespace App\Controller;

use App\Entity\Absence;
use App\Entity\AbsencesReport;
use App\Entity\Group;
use App\Form\AbsencesReportType;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AbsenceController extends AbstractController
{
    #[Route('/report/{id}/create', name: 'absence_create_report')]
    public function create(Group $group, Request $request,EntityManagerInterface $manager): Response
    {
        $students = $group->getAllStudents();

        $absenceReport = new AbsencesReport();
        $absenceReport->setName($group->getName());

        $form = $this->createForm(AbsencesReportType::class, $absenceReport, [
            'students' => $students->toArray()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($students as $student){
                $absenceReport->addStudentsGroup($student);
            }
            $this->crudAbsenceReport($form, $students, $absenceReport, $manager);
            $manager->persist($absenceReport);
            $manager->flush();
            $this->addFlash('success', "Le rapport a été correctement été enregistrée !");
            return $this->redirectToRoute('absence_edit_report', [
                'id' => $absenceReport->getId()
            ]);
        }


        return $this->render('absence/createReport.html.twig', [
            'form' => $form->createView(),
            'group'=> $group
        ]);
    }

    #[Route('/report/{id}/edit', name: 'absence_edit_report')]
    public function edit(AbsencesReport $absenceReport, Request $request,EntityManagerInterface $manager): Response
    {
        $students = $absenceReport->getStudentsGroup();
        $studentsSelected = $absenceReport->getStudents();
        $groupTD = new Group();
        $groupTD->setName("Test : ");




        $form = $this->createForm(AbsencesReportType::class, $absenceReport, [
            'students' => $students->toArray(),
            'studentsSelected' => $studentsSelected->toArray()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->crudAbsenceReport($form, $students, $absenceReport, $manager);
            $manager->persist($absenceReport);
            $manager->flush();
            $this->addFlash('success', "Le rapport a été correctement été modifié !");
            return $this->redirectToRoute('absence_edit_report', [
                'id' => $absenceReport->getId()
            ]);
        }


        return $this->render('absence/createReport.html.twig', [
            'form' => $form->createView(),
            'group'=> $groupTD
        ]);
    }







    /**
     * @param FormInterface $form
     * @param Collection $studentsInGroup
     * @param AbsencesReport $absenceReport
     * @param EntityManagerInterface $manager
     */
    public function crudAbsenceReport(FormInterface $form, Collection $studentsInGroup, AbsencesReport $absenceReport, EntityManagerInterface $manager): void
    {
        //On récupère les étudiants absents
        $studentsForm = $form->get('students')->getData();

        foreach ($studentsInGroup as $student) {
            foreach ($student->getAbsences() as $absence) {
                if ($absence->getAbsencesReport() === $absenceReport && !in_array($student, $studentsForm, true)) {
                    $absence->setAbsencesReport(null);
                    $student->removeAbsence($absence);
                    $manager->persist($absence);
                    $manager->persist($student);
                }
            }
        }

        //On récupère les étudiants absents
        foreach ($studentsForm as $student) {
            $reportExist = false;
            foreach ($student->getAbsences() as $absence) {
                if ($absence->getAbsencesReport() === $absenceReport) {
                    $reportExist = true;
                }
            }
            if (!$reportExist) {
                $absence = new Absence();
                $absence->setAbsencesReport($absenceReport);
                $absence->setStudent($student);
                $student->addAbsence($absence);
                $manager->persist($absence);
                $manager->persist($student);
            }

        }
    }
}
