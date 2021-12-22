<?php

namespace App\Controller;

use App\Entity\Group;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_TEACHER')]
class HomeController extends AbstractController
{

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
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
