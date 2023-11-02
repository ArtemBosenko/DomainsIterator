<?php

namespace App\Controller\Admin;

use App\Admin\Filter\DomainsDateFilter;
use App\Admin\Filter\DomainsRepeaterFilter;
use App\Entity\Domain;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class DomainCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Domain::class;
    }

    final public function configureAssets(Assets $assets): Assets
    {
        return $assets
            ->addWebpackEncoreEntry('app')
        ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Domain')
            ->setEntityLabelInPlural('Domains')
            ->setSearchFields(['name'])
            ->setDefaultSort(['name' => 'DESC'])
            ->showEntityActionsInlined()
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('urls', 'Domain URL'))
            ->add(DomainsDateFilter::new('urls.data.date', 'Filter Domains by date'))
            ->add(DomainsRepeaterFilter::new('urls.data.status', 'Filter Domains by status'))
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield UrlField::new('name', 'Domain url')->setRequired(true);

        yield CollectionField::new('urls', 'Domain pages URLs')
            ->setEntryIsComplex(true)
            ->setColumns('12')
            ->useEntryCrudForm()
            ->setRequired(true)
        ;
    }
}
