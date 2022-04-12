<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart')]
    public function index(SessionInterface $session): Response
    {
        dd($session->get('cart'));
        // return $this->render('cart/index.html.twig', [
        //     'controller_name' => 'CartController',
        // ]);
    }

    #[Route('/cart/add/{slug}', name: 'add_cart')]
    public function addCart(Product $product, SessionInterface $session): Response
    {
        $cart = $session->get('cart', []);
        $productId = $product->getId();
        if(array_key_exists($productId, $cart)){
            $cart[$productId]++;
        } 
        else {
            $cart[$productId] = 1;
        }
        $session->set('cart', $cart);


        return $this->redirectToRoute('cart');
    }
}
