<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class HomeController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function home(): Response
    {
        return $this->render('admin/home.html.twig');
    }

    #[Route('/', name: 'redirect_dashboard')]
    public function redirectDashBord(): RedirectResponse
    {
        return $this->redirectToRoute('admin_dashboard');
    }
}
