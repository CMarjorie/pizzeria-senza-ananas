<?php

namespace App\Controller;

use App\Entity\Extra;
use App\Entity\Product;
use App\Entity\PizzaDetail;
use App\Form\PizzaDetailType;
use App\Repository\ExtraRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\BillingPortal\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route('/pizza/add/{slug}', name: 'cart_add')]
    /** responsable de traiter la soumission du formulaire */
    public function addToCart(Request $request, Product $product, PizzaDetail $pizzaDetail, SessionInterface $session, Extra $extra)
    {
        // $quantity = $request->get("quantity");
        // $extras = $request->get("extras");
        // $cart = $session->get('cart', []);

        // if ($form->isSubmitted() && $form->isValid()) {
        // } else {
        //     return $this->redirectToRoute('pizza_detail');
        // }
    }

    /** responsable de créer le formulaire en fonction du produit */
    public function buildAddfom(Product $product): \Symfony\Component\Form\FormView
    {
        $pizzaDetail = new PizzaDetail();
        $pizzaDetail->setProduct($product);
        $form = $this->createForm(PizzaDetailType::class, $pizzaDetail);
        $formView = $form->createView();
        return $formView;
    }


    #[Route('/pizza/{slug}', name: 'pizza_detail')]
    /** retourne la vue du produit */
    public function show(Product $product, ProductRepository $productRepo, ExtraRepository $extra, SessionInterface $session, EntityManagerInterface $entityManager, Request $request,): Response
    {
        return $this->render('product/index.html.twig', [
            'product' => $product,
            'form' => $this->buildAddfom($product),
        ]);
    }
}
