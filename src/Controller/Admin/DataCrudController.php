<?php

namespace App\Controller\Admin;

use App\Entity\Data;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class DataCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Data::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Data')
            ->setEntityLabelInPlural('Data')
            ->setSearchFields(['date', 'status'])
            ->setDefaultSort(['status' => 'DESC'])
            ->showEntityActionsInlined()
            ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(TextFilter::new('date', 'Date'))
            ->add(TextFilter::new('status', 'Status'))
            ;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('url', 'Parent URL');
        yield DateTimeField::new('date', 'Date');
        yield TextField::new('status', 'Status');
    }
    
}
