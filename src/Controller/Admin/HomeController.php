<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class HomeController extends AbstractController
{
    #[Route('/dashbord', name: 'dashbord')]
    public function home(): Response
    {
        return $this->render('admin/home.html.twig');
    }
}
