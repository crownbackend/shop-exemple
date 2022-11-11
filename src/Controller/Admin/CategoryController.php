<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\Admin\CategoryType;
use App\Repository\CategoryRepository;
use App\Service\FileUploader;
use App\Service\Slugger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/category', name: 'admin_category_')]
class CategoryController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private FileUploader $fileUploader;
    private Slugger $slugger;
    private CategoryRepository $categoryRepository;

    public function __construct(EntityManagerInterface $entityManager, FileUploader $fileUploader, Slugger $slugger,
                                CategoryRepository $categoryRepository)
    {
        $this->entityManager = $entityManager;
        $this->fileUploader = $fileUploader;
        $this->slugger = $slugger;
        $this->categoryRepository = $categoryRepository;
    }

    #[Route('/', name: 'category')]
    public function home(): Response
    {
        return $this->render('admin/category/home.html.twig', [
            'categories' => $this->categoryRepository->findAll()
        ]);
    }

    #[Route('/add', name: 'add')]
    public function add(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();
            if($imageFile) {
                $imageFileName = $this->fileUploader->upload($imageFile, $this->getParameter('category_directory'));
                $category->setImage($imageFileName);
                $category->setSlug($this->slugger->slug($category->getName()));
                $this->entityManager->persist($category);
                $this->entityManager->flush();
                $this->addFlash('success', 'Catégorie ajouter avec succès');
                return $this->redirectToRoute('admin_category_category');
            }
        }

        return $this->render('admin/category/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
