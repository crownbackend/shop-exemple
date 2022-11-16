<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Entity\Product;
use App\Form\Admin\ProductType;
use App\Repository\ProductRepository;
use App\Service\FileUploader;
use App\Service\Slugger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/products', name: 'admin_product_')]
class ProductController extends AbstractController
{
    private ProductRepository $productRepository;
    private FileUploader $uploader;
    private EntityManagerInterface $entityManager;
    private Slugger $slugger;

    public function __construct(ProductRepository $productRepository, FileUploader $uploader,
                                EntityManagerInterface $entityManager, Slugger $slugger)
    {
        $this->productRepository = $productRepository;
        $this->uploader = $uploader;
        $this->entityManager = $entityManager;
        $this->slugger = $slugger;
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
            /** @var UploadedFile $imageFile */
            $imageFiles = $form->get('images')->getData();
            foreach ($product->getCategories() as $category) {
                $category->addProduct($product);
            }
            if($imageFiles) {
                foreach ($imageFiles as $imageFile) {
                    $imageFileName = $this->uploader->upload($imageFile,  $this->getParameter('product_images'));
                    $image = new Image();
                    $image->setName($imageFileName);
                    $image->setAlt($imageFileName);
                    $product->addImage($image);
                }
            }
            $product->setSlug($this->slugger->slug($product->getName()));
            $this->entityManager->persist($product);
            $this->entityManager->flush();
            $this->addFlash('success', 'Produit ajouter avec succès');
            return $this->redirectToRoute('admin_product_home');

        }
        return $this->render('admin/product/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
