<?php

namespace App\Controller\Admin;

use App\Admin\Filter\DomainsDateFilter;
use App\Admin\Filter\DomainsRepeaterFilter;
use App\Entity\URL;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;

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
        yield UrlField::new('address', 'URL')->setRequired(true);
        yield CollectionField::new('data', 'URLs data')
            ->setEntryIsComplex(true)
            ->setColumns('12')
            ->useEntryCrudForm()
            ->setFormTypeOptions([
                'by_reference' => false,
            ])
            ->setRequired(true)
        ;
    }
}
