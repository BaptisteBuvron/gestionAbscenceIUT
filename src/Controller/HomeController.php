<?php

namespace App\Controller;

use App\Entity\Group;
use App\Form\ChooseGroupType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_TEACHER')]
class HomeController extends AbstractController
{

    #[Route('/', name: 'new_report')]
    public function newReport(EntityManagerInterface $manager, Request $request): Response
    {

        $form = $this->createForm(ChooseGroupType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $group = $form->get('group')->getData();
            return $this->redirectToRoute('report_absence_create', ['id' => $group->getId()]);
        }

        return $this->render('home/new_report.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/chart', name: 'chart_organization')]
    public function chartOrganization(EntityManagerInterface $manager): Response
    {
        $groups = $manager->getRepository(Group::class)->findBy(['isParent' => true]);
        return $this->render('home/chart_organization.html.twig', [
            'groups' => $groups
        ]);
    }


}
