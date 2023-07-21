<?php

namespace App\Controller\Admin;

use App\Entity\Domain;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
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
            // ->add(EntityFilter::new('data', 'Domain URL'))
            // ->add(TextFilter::new('urls.date', 'Domain URL date'))
            // ->add(TextFilter::new('urls.status', 'Domain URL status'))
            ;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Domain name');

        
        // return [
        //     // IdField::new('id'),
        //     TextField::new('name','Domain name'),
        //     // TextEditorField::new('description'),
        // ];
    }
}
