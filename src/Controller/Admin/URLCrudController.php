<?php

namespace App\Controller\Admin;

use App\Entity\URL;
use App\Form\Type\DataType;
use App\Admin\Filter\DomainsDateFilter;
use App\Admin\Filter\DomainsRepeaterFilter;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Form\Filter\Type\DateTimeFilterType;

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
            ->add(TextFilter::new('address', 'Filter URLs address'))
            ->add(DomainsDateFilter::new('data.date', 'Filter URLs by date'))
            ->add(DomainsRepeaterFilter::new('data.status', 'Filter URLs by status'))
            ;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('domain', 'Parent Domain');
        yield UrlField::new('address', 'URL');
        yield CollectionField::new('data', 'URLs data')
        ->setFormTypeOption('entry_type', DataType::class)
        ->setEntryIsComplex(true)
        ->setColumns('12')
    ;
    }
    
}
