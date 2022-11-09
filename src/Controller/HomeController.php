<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/{_locale}/', name: 'home')]
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }

    #[Route('/', name: 'redirect_locale')]
    public function redirectLocale(Request $request): RedirectResponse
    {
        $locale = $request->getLocale();
        return $this->redirectToRoute('home', [
            '_locale' => $locale
        ]);
    }
}
