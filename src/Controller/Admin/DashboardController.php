<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\User;
use App\Repository\ProjetRepository;
use App\Task\SendProjectDeadlineNotificationTask;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use PhpParser\Node\Stmt\Echo_;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class DashboardController extends AbstractDashboardController
{
    private $security;
    public function __construct(private AdminUrlGenerator $adminUrlGenerator, Security $security)
    {
        $this->security = $security;
    }
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator
            ->setController(ProjetCrudController::class)
            ->generateUrl();
        return $this->redirect($url);
    }


    #[Route('/test', name: 'test')]
    public function test(MessageBusInterface $bus, ProjetRepository $projetRepository, MailerInterface $mailer): Response
    {
        /*$dn = new \DateTime();
        $dn->modify('+7 day');
        $projets = $projetRepository->findProjetsDeadline($dn);
        dump($projets);
        die;*/

        $s = new SendProjectDeadlineNotificationTask($bus, $projetRepository, $mailer);
        if ($s == false) {
            return new Response('OOOOOOOOOOK!');
        } else {
            return new Response('nooooooooooooooooo');
        }
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('App');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Projets', 'fa fa-home');
        if ($this->security->isGranted('ROLE_ADMIN')) {
            yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-person', User::class);
        }
    }
}
