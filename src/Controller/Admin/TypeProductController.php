<?php

namespace App\Controller\Admin;

use App\Entity\TypeProduct;
use App\Form\Admin\TypeProductType;
use App\Repository\TypeProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/type/product', name: 'admin_type_product_')]
class TypeProductController extends AbstractController
{
    private TypeProductRepository $typeProductRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(TypeProductRepository $typeProductRepository, EntityManagerInterface $entityManager)
    {
        $this->typeProductRepository = $typeProductRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'home')]
    public function home(): Response
    {
        return $this->render('admin/type_product/home.html.twig', [
            'typeProducts' => $this->typeProductRepository->findAll()
        ]);
    }

    #[Route('/add', name: 'add')]
    public function add(Request $request): Response
    {
        $typeProduct = new TypeProduct();
        $form = $this->createForm(TypeProductType::class, $typeProduct);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($typeProduct);
            $this->entityManager->flush();

            return $this->redirectToRoute('admin_type_product_home');
        }

        return $this->render('admin/type_product/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
