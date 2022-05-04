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
    /** responsable de créer le formulaire en fonction du produit */
    public function buildAddform(Product $product): \Symfony\Component\Form\FormView
    {
        $pizzaDetail = new PizzaDetail();
        $pizzaDetail->setProduct($product);
        $form = $this->createForm(PizzaDetailType::class, $pizzaDetail, [
            'action' => $this->generateUrl('add_cart', ["slug" => $product->getSlug()]),
            'method' => 'POST',
        ]);
        $formView = $form->createView();
        return $formView;
    }


    #[Route('/pizza/{slug}', name: 'pizza_detail')]
    /** retourne la vue du produit */
    public function show(Product $product): Response
    {
        return $this->render('product/index.html.twig', [
            'product' => $product,
            'form' => $this->buildAddform($product),
        ]);
    }
}
