<?php

namespace App\Controller\Admin;

use App\Entity\URL;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class URLCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return URL::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('URL')
            ->setEntityLabelInPlural('URLs')
            ->setSearchFields(['name'])
            ->setDefaultSort(['domain' => 'DESC'])
            ->showEntityActionsInlined()
            ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('data', 'URL data'))
            ->add(EntityFilter::new('domain', 'URL domain'))
            // ->add(EntityFilter::new('data', 'Domain URL'))
            // ->add(TextFilter::new('urls.date', 'Domain URL date'))
            // ->add(TextFilter::new('urls.status', 'Domain URL status'))
            ;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'URL');



        // return [
        //     IdField::new('id'),
        //     TextField::new('title'),
        //     TextEditorField::new('description'),
        // ];

    }
    
}
