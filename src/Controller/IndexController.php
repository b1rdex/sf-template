<?php

namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', 'index')]
    public function __invoke(AdminUrlGenerator $adminUrlGenerator): RedirectResponse
    {
        return $this->redirectToRoute('admin');
    }
}
