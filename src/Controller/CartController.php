<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart')]
    public function index(ProductRepository $productRepo, SessionInterface $session): Response
    {

        $cart = $session->get('cart', []);
        $products = [];
        foreach ($cart as $id => $quantity) {
            $product = $productRepo->find($id);
            $product->setQuantity($quantity);
            $products[] = $product;
        }
        return $this->render('cart/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/cart/add/{slug}', name: 'add_cart')]
    public function addCart(Request $request, Product $product, SessionInterface $session): Response
    {

        $quantityDetail = $request->get('pizza_detail[quantity]', null, true);
        $quantity = $request->get('quantity');
        $cart = $session->get('cart', []);
        $productId = $product->getId();
        if ($quantity) {
            $cart[$productId] = $quantity;
        } else {
            dump('toto');
        }
        $extras = $request->get("extra");

        dump($quantity);
        dump($quantityDetail);
        dump($cart);
        die();
        // $cart[$productId]['extras'] += $extras;
        $successMessage = array_key_exists($productId, $cart)
            ? "Votre modification a été prise en compte !"
            : "Votre pizza a bien été ajoutée au panier !";
        $this->addFlash('success', $successMessage);

        $session->set('cart', $cart);
        $referer = $request->headers->get('referer');

        return $this->redirect($referer);
    }

    #[Route('/cart/remove/{slug}', name: 'remove_cart')]
    public function removeCart(Product $product, SessionInterface $session): Response
    {
        $this->addFlash("danger", "Votre pizza a bien été supprimée du panier");
        $cart = $session->get('cart', []);
        $productId = $product->getId();
        unset($cart[$productId]);

        $session->set('cart', $cart);

        return $this->redirectToRoute('cart');
    }

    #[Route('/cartQuantity', name: 'cart_quantity')]
    public function cartQuantity(SessionInterface $session): Response
    {
        $totalQuantity = 0;
        foreach ($session->get('cart', []) as $id => $quantity) {
            if ($quantity > 0) {
                $totalQuantity += $quantity;
            }
        }

        return new Response($totalQuantity);
    }
}
