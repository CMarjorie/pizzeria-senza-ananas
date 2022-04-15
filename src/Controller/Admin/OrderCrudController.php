<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Form\DetailOrderType;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $config = parent::configureFields($pageName);
        $config[] =
            CollectionField::new('detailOrder')
            ->setEntryType(DetailOrderType::class)
            ->allowAdd(false);
        $config[] = MoneyField::new('amount')->setCurrency('EUR');
        return $config;
    }
}
