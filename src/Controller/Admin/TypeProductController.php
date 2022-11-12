<?php

namespace App\Controller\Admin;

use App\Repository\TypeProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/type/product', name: 'admin_type_product_')]
class TypeProductController extends AbstractController
{
    private TypeProductRepository $typeProductRepository;

    public function __construct(TypeProductRepository $typeProductRepository)
    {
        $this->typeProductRepository = $typeProductRepository;
    }

    #[Route('/', name: 'home')]
    public function home(): Response
    {
        return $this->render('admin/type_product/home.html.twig', [
            'typeProducts' => $this->typeProductRepository->findAll()
        ]);
    }
}
