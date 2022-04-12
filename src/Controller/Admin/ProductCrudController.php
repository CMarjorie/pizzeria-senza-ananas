<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
           // IdField::new('id'),
            TextField::new('name'),
            SlugField::new('slug')->setTargetFieldName('name'),
            TextEditorField::new('description'),
            MoneyField::new('price')->setCurrency('EUR'),
            ImageField::new('photo')->setBasePath('uploads')
                                    ->setUploadDir('public/uploads')
                                    ->setUploadedFileNamePattern('[slug]-[contenthash].[extension]')
                                    ->setRequired(false)
        ];
    }
    
}
