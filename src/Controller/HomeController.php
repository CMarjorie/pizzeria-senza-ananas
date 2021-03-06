<?php

namespace App\Controller;

use App\Entity\PizzaDetail;
use App\Entity\Product;
use App\Repository\ExtraRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(SessionInterface $session, ProductRepository $productRepo): Response
    {
        $products = $productRepo->findAll();
        $cart = $session->get('cart', []);
        foreach ($products as $product) {
            if (array_key_exists($product->getId(), $cart)) {
                $product->setQuantity($cart[$product->getId()]['quantity']);
            } else {
                $product->setQuantity(0);
            }
        }
        //dd($products);
        return $this->render('home/index.html.twig', [
            'products' => $products,
        ]);
    }
}
