<?php

namespace App\Controller\Admin;

use App\Entity\URL;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class URLCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return URL::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
