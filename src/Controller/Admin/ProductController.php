<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Entity\Product;
use App\Form\Admin\ProductType;
use App\Repository\ProductRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
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

             /** @var UploadedFile $imageFile */
            if($form->get('images')->getData()) {
                foreach ($form->get('images')->getData() as $datum) {
                    $imageFileName = $this->uploader->upload($datum, $this->getParameter('product_directory'));
                    $image = new Image();
                    $image->setName($imageFileName);
                    $image->setAlt($imageFileName);
                    $product->addImage($image);
                }
            }
            foreach ($product->getCategories() as $category) {
                $category->addProduct($product);
            }
            $product->setSlug($this->slugger->slug($product->getName()));
            $this->productRepository->save($product, true);
            $this->addFlash('success', 'Produit ajouter avec succès');
            return $this->redirectToRoute('admin_product_edit', ['id' => $product->getId()]);

        }
        return $this->render('admin/product/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}/edit', name: 'edit')]
    public function edit(Product $product, Request $request)
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $imageFile */
            if($form->get('images')->getData()) {
                foreach ($form->get('images')->getData() as $datum) {
                    $imageFileName = $this->uploader->upload($datum, $this->getParameter('product_directory'));
                    $image = new Image();
                    $image->setName($imageFileName);
                    $image->setAlt($imageFileName);
                    $product->addImage($image);
                }
            }
            $this->productRepository->save($product, true);
            $this->addFlash('success', 'Produit ajouter avec succès');
            return $this->redirectToRoute('admin_product_home');

        }

        return $this->render('admin/product/edit.html.twig', [
            'form' => $form->createView(),
            'product' => $product
        ]);
    }

    #[Route("/{id}/delete", name: 'delete')]
    public function delete(Product $product): RedirectResponse
    {
        foreach ($product->getImages() as $image) {
            $this->uploader->delete($image->getName(), 'product_directory');
        }
        $this->productRepository->remove($product, true);
        return $this->redirectToRoute('admin_product_home');
    }
}
