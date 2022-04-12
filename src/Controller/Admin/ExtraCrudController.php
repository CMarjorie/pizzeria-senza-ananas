<?php

namespace App\Controller\Admin;

use App\Entity\Extra;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ExtraCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Extra::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            //IdField::new('id'),
            TextField::new('name'),
            MoneyField::new('price')->setCurrency('EUR')
        ];
    }
}
