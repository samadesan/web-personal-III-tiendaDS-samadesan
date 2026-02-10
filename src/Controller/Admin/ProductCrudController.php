<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nombre del Producto'),
            ImageField::new('photo', 'Imagen')
                ->setUploadDir('public/img/products') // Carpeta para productos
                ->setBasePath('img/products'),
            NumberField::new('price', 'Precio')
                ->setNumDecimals(2),
        ];
    }
}