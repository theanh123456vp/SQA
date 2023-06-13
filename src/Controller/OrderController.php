<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderFormType;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class OrderController extends AbstractController
{
    private $em;
    private $productRepository;
    private $userRepository;
    public function __construct(EntityManagerInterface $em, ProductRepository $productRepository, UserRepository $userRepository)
    {
        $this->em = $em;
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
    }

    #[Route('/order/product/{id}', name: 'app_order')]
    public function order(Request $request, EntityManagerInterface $entityManager, $id,SessionInterface $session): Response
    {

        $productID = $this->productRepository->find($id);
        $order = new Order();
        $forms = $this->createForm(OrderFormType::class, $order);
        $forms->handleRequest($request);

        if ($forms->isSubmitted() && $forms->isValid()) {

            // encode the plain password
            $entityManager->persist($order);
            $entityManager->flush();
            $session->getFlashBag()->add('success', 'Đặt hàng thành công!');

            return new RedirectResponse($this->generateUrl('index'));
        }

        if (!($forms->isSubmitted())) {
            $forms->get('productName')->setData(($productID->getName()));
            $forms->get('productPrice')->setData(($productID->getPrice()));         
        }
        if ($forms->isSubmitted() && !($forms->isValid())) {
            echo '<script>alert("Sai thông tin liên hệ!")</script>';
        }


        return $this->render('registration/order.html.twig', [
            'productID' => $productID,
            'orderForm' => $forms->createView(),

        ]);
    }

}