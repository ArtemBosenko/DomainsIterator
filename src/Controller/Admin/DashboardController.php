<?php

namespace App\Controller\Admin;

use App\Entity\Data;
use App\Entity\Domain;
use App\Entity\URL;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

use function Symfony\Component\Translation\t;

class DashboardController extends AbstractDashboardController
{
    private AdminUrlGenerator $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    final public function configureCrud(): Crud
    {
        return parent::configureCrud()
            ->addFormTheme('@EasyMedia/form/easy-media.html.twig')
        ;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //

        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect($adminUrlGenerator->setController(DomainCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('DomainsIterator');
    }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        yield MenuItem::section('Post Types');
        yield MenuItem::linkToCrud('Domains', 'fa fa-edit', Domain::class);
        yield MenuItem::section('Media');
        yield MenuItem::linkToRoute('Medias', 'fa fa-picture-o', 'media.index');
        yield MenuItem::section('Users')->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Users', 'fa fa-users', User::class)->setPermission('ROLE_ADMIN');

        // yield MenuItem::subMenu('Domains', 'fa fa-article')->setSubItems([
        //     MenuItem::linkToCrud('Domains', 'fa fa-edit', Domain::class),
        // ]);
        yield MenuItem::section('SubTables');
        yield MenuItem::linkToCrud('URLS', 'fa fa-check-circle-o', URL::class);
        yield MenuItem::linkToCrud('URLs data', 'fa fa-calendar', Data::class);
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        $userMenu = parent::configureUserMenu($user);
        $targetUrl = $this->adminUrlGenerator
            ->setController(UserCrudController::class)
            ->setAction(Crud::PAGE_EDIT)
            ->setEntityId($user->getId())
            ->generateUrl();

        return $userMenu->addMenuItems(
            [
                MenuItem::linkToUrl(t('Edit '.$user->getUserIdentifier(), domain: 'DomainsApp'), 'fa-user', $targetUrl),
            ]
        );
    }
}
