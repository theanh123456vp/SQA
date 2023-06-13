<?php

namespace App\Controller;


use App\Form\ProductSearchType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    private $productResponsitory;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productResponsitory = $productRepository;
    }

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $product = $this->productResponsitory->findAll();
        return $this->render("index.html.twig", [
            'product' => $product,
        ]);

    }

    #[Route('/product', name: 'product')]
    public function product(Request $request): Response
    {

        $form = $this->createForm(ProductSearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->get('search')->getData();
            $product = $this->productResponsitory->findByName($search);
        } else {
            $product = $this->productResponsitory->findAll();
        }
        
        return $this->render("product.html.twig", [
            'product' => $product,
            'form' => $form->createView(),
        ]);

    }
}
