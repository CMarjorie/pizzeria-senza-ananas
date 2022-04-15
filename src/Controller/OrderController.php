<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Entity\DetailOrder;
use App\Entity\PizzaDetail;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{

    #[Route('/order/new', name: 'create_order')]
    public function create(SessionInterface $session, EntityManagerInterface $entityManager, Request $request, ProductRepository $prodRepo): Response
    {
        $token = bin2hex(random_bytes(10));
        $session->set("token_payment", $token);

        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cumul = 0;
            $line_items=[];

            foreach ($session->get('cart', []) as $id=>$quantity) {

                $pizza = new PizzaDetail();
                $product = $prodRepo->find($id);
                $pizza->setProduct($product);
                $pizza->setPrice($product->getPrice());

                $entityManager->persist($pizza);

                $detail = new DetailOrder();
                $detail->setQuantity($quantity);
                $detail->setTotalPrice($quantity * $pizza->getPrice());
                $detail->setPizzaDetail($pizza);
                $detail->setOrders($order);

                $entityManager->persist($detail);

                $cumul += $detail->getTotalPrice();

                $line_item = [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => $product->getName(),
                        ],
                        'unit_amount' => $product->getPrice(),
                    ],
                    'quantity' => $quantity,
                ];
                $line_items[] = $line_item;
            }

            $order->setDate(new \DateTime());
            $order->setStatus('waiting');
            $order->setAmount($cumul);

            $entityManager->persist($order);
            $entityManager->flush();
            $session->set("order_id", $order->getId());

            
            \Stripe\Stripe::setApiKey('sk_test_51KokjsLbHZy6sDpHNr02qQODeJbzLGzTphLGhQy2yIp15pXYidU6f3UgRhGUKkl2Gb07G80pjq8w1QoaoEK4EoPe00FIuF1Xqd');
            $session = \Stripe\Checkout\Session::create([
                'line_items' => $line_items,
                'mode' => 'payment',
                'success_url' => "http://127.0.0.1:8000/checkout_success/$token",
                'cancel_url' => 'http://127.0.0.1:8080/checkout_error'
            ]);

            return $this->redirect($session->url, 303);

            // $this->addFlash('success', 'Vos pizzas sont en route');
            // return $this->redirectToRoute('home');
        } else {
            return $this->renderForm('order/new.html.twig', [
                'order_form' => $form,
                'title' => 'Création commande'
            ]);
        }
    }

    #[Route('/checkout_success/{token}', name: 'success_url')]
    public function checkout_success(string $token, SessionInterface $session, OrderRepository $orderRepo, EntityManagerInterface $entityManager): Response
    {
        if ($session->get('token_payment') === $token) {
            $order = $orderRepo->find($session->get('order_id'));

            $order->setStatus('payed');
            $entityManager->flush();

            $session->set('cart', []);

            return $this->render('order/index.html.twig', [
                'title' => 'Commande',
            ]);
        } else {
            return $this->render('error.html.twig');
        }
    }


    #[Route('/checkout_error', name: 'cancel_url')]
    public function checkout_error(): Response
    {
        return $this->render('error.html.twig');
    }


    #[Route('/order', name: 'order')]
    public function index(): Response
    {
        return $this->render('order/index.html.twig', [
            'controller_name' => 'OrderController',
        ]);
    }
}

