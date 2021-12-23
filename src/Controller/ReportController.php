<?php

namespace App\Controller;

use App\Entity\Absence;
use App\Entity\AbsencesReport;
use App\Entity\Group;
use App\Entity\Teacher;
use App\Form\AbsencesReportType;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReportController extends AbstractController
{
    #[Route("/reports", name : "report_absences_list")]
    #[IsGranted('ROLE_YEAR_RESPONSIBLE')]
    public function index(EntityManagerInterface $manager): Response
    {
        $repositoryReport = $manager->getRepository(AbsencesReport::class);
        $reports = $repositoryReport->findAll();

        return $this->render('report/list.html.twig', [
            'reports' => $reports
        ]);

    }

    #[Route('/report/{id}/create', name: 'report_absence_create')]
    #[IsGranted('ROLE_TEACHER')]
    public function createReport(Group $group, Request $request,EntityManagerInterface $manager): Response
    {
        $students = $group->getAllStudents();

        $absenceReport = new AbsencesReport();
        $date = new \DateTime();
        $absenceReport->setDate($date);
        $absenceReport->setName($group->getName() . ' -  ' . $date->format('d-m-Y'));

        $user = $this->getUser();
        if ($user instanceof Teacher) {
            $absenceReport->setTeacher($user);
        }

        $form = $this->createForm(AbsencesReportType::class, $absenceReport, [
            'students' => $students->toArray(),
            'disabledChoiceTeacher' => $user instanceof Teacher,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($user instanceof Teacher) {
                $absenceReport->setTeacher($user);
            }
            foreach ($students as $student){
                $absenceReport->addStudentsGroup($student);
            }
            $this->crudAbsenceReport($form, $students, $absenceReport, $manager);
            $manager->persist($absenceReport);
            $manager->flush();
            $this->addFlash('success', "Le rapport a été correctement été enregistrée !");

            if ($this->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('report_absence_edit', [
                    'id' => $absenceReport->getId()
                ]);
            }
            return $this->redirectToRoute('home');

        }


        return $this->render('report/createReport.html.twig', [
            'form' => $form->createView(),
            'absenceReport'=> $absenceReport
        ]);
    }

    #[Route('/report/{id}/edit', name: 'report_absence_edit')]
    #[IsGranted('ROLE_ADMIN')]
    public function editReport(AbsencesReport $absenceReport, Request $request,EntityManagerInterface $manager): Response
    {
        $students = $absenceReport->getStudentsGroup();
        $studentsSelected = $absenceReport->getStudentsAbsent();




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
            return $this->redirectToRoute('report_absence_edit', [
                'id' => $absenceReport->getId()
            ]);
        }


        return $this->render('report/editReport.html.twig', [
            'form' => $form->createView(),
            'absenceReport'=> $absenceReport
        ]);
    }

    #[Route('/report/{id}', name: 'report_absence_show')]
    #[IsGranted('ROLE_YEAR_RESPONSIBLE')]
    public function showReport(AbsencesReport $absenceReport): Response
    {
        return $this->render('report/showReport.html.twig', [
            'absenceReport' => $absenceReport
        ]);
    }

    #[Route('/report/{id}/delete', name: 'report_absence_delete')]
    #[IsGranted('ROLE_ADMIN')]
    public function deleteReport(AbsencesReport $absenceReport, EntityManagerInterface $manager): Response
    {
        //TODO : delete csrf token
        foreach ($absenceReport->getAbsences() as $absence){
            $manager->remove($absence);
        }
        $manager->remove($absenceReport);
        $manager->flush();
        $this->addFlash('success', "Le rapport a été correctement été supprimé !");
        return $this->redirectToRoute('report_absences_list');
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