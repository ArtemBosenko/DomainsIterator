<?php

namespace App\Controller\Admin;

use App\Entity\Domain;
use App\Form\Type\UrlsType;
use App\Admin\Filter\DomainsDateFilter;
use App\Admin\Filter\DomainsRepeaterFilter;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class DomainCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Domain::class;
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
       yield TextField::new('name', 'Domain name');

       yield CollectionField::new('urls', 'Domain URLs')
           ->setFormTypeOption('entry_type', UrlsType::class)
           ->setEntryIsComplex(true)
           ->setColumns('12')
       ;
    }
}
