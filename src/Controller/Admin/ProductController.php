<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Entity\Product;
use App\Form\Admin\ProductType;
use App\Repository\ProductRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/products', name: 'admin_product_')]
class ProductController extends AbstractController
{
    private ProductRepository $productRepository;
    private SluggerInterface $slugger;
    private FileUploader $uploader;

    public function __construct(ProductRepository $productRepository, SluggerInterface $slugger, FileUploader $uploader)
    {
        $this->productRepository = $productRepository;
        $this->slugger = $slugger;
        $this->uploader = $uploader;
    }

    #[Route('/', name: 'home')]
    public function home(): Response
    {
        return $this->render('admin/product/index.html.twig', [
            'products' => $this->productRepository->findAll()
        ]);
    }

    #[Route('/add', name: 'add')]
    public function add(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            /*
            if($form->get('images')->getData()) {
                foreach ($form->get('images')->getData() as $datum) {
                    $imageFileName = $this->uploader->upload($datum, $this->getParameter('product_directory'));
                    $image = new Image();
                    $image->setName($imageFileName);
                    $product->addImage($image);
                }
            }*/

            dd($product);
        }
        return $this->render('admin/product/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
