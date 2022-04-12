<?php

namespace App\Entity;

use App\Repository\DetailOrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetailOrderRepository::class)]
class DetailOrder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $quantity;

    #[ORM\Column(type: 'float')]
    private $totalPrice;

    #[ORM\ManyToOne(targetEntity: PizzaDetail::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $pizzaDetail;

    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: 'detailOrder')]
    #[ORM\JoinColumn(nullable: false)]
    private $orders;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(float $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getPizzaDetail(): ?PizzaDetail
    {
        return $this->pizzaDetail;
    }

    public function setPizzaDetail(?PizzaDetail $pizzaDetail): self
    {
        $this->pizzaDetail = $pizzaDetail;

        return $this;
    }

    public function getOrders(): ?Order
    {
        return $this->orders;
    }

    public function setOrders(?Order $orders): self
    {
        $this->orders = $orders;

        return $this;
    }
}
