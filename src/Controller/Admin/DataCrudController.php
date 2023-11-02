<?php

namespace App\Controller\Admin;

use Adeliom\EasyMediaBundle\Admin\Field\EasyMediaField;
use App\Entity\Data;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;

class DataCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Data::class;
    }

    final public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Data')
            ->setEntityLabelInPlural('Data')
            ->setSearchFields(['date', 'status'])
            ->setDefaultSort(['status' => 'DESC'])
            ->showEntityActionsInlined()
        ;
    }

    final public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(DateTimeFilter::new('date', 'Date'))
            ->add(TextFilter::new('status', 'Status'))
        ;
    }

    final public function configureFields(string $pageName): iterable
    {
        yield DateTimeField::new('date', 'Date')->setRequired(true);
        yield TextField::new('status', 'Status')->setRequired(true);
        yield EasyMediaField::new('screenshot', 'Screenshot')
            ->setFormTypeOption('restrictions_uploadTypes', ['image/*'])
            ->setFormTypeOption('restrictions_uploadSize', 5.0)
            ->setFormTypeOption('editor', true)
            ->setFormTypeOption('upload', true)
            ->setFormTypeOption('bulk_selection', true)
            ->setFormTypeOption('move', true)
            ->setFormTypeOption('rename', true)
            ->setFormTypeOption('metas', true)
            ->setFormTypeOption('delete', true)
        ;
        yield BooleanField::new('has_error', 'Has Error');
        yield TextareaField::new('error_description', 'Error description');
    }
}
