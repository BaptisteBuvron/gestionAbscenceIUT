<?php

namespace App\Controller;

use App\Entity\AbsencesReport;
use App\Form\AbsencesReportType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AbsenceController extends AbstractController
{
    #[Route('/absencesReport/create', name: 'absence_create_report')]
    public function create(Request $request,EntityManagerInterface $manager): Response
    {
        $absenceReport = new AbsencesReport();
        $form = $this->createForm(AbsencesReportType::class, $absenceReport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            foreach ($absenceReport->getAbsences() as $absence) {
                $absence->setAbsencesReport($absenceReport);
                $manager->persist($absence);
                $student = $absence->getStudent();
                $student->addAbsence($absence);
                $manager->persist($student);
            }


            $manager->persist($absenceReport);
            $manager->flush();
            $this->addFlash('success', "Le rapport a été correctement été enregistrée !");
            return $this->redirectToRoute('home');
        }


        return $this->render('absence/createReport.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
