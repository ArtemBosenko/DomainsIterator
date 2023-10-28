<?php

namespace App\Controller\Admin;

use App\Entity\Data;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
            ->add(DateTimeFilter::new('date', 'Date'))
            ->add(TextFilter::new('status', 'Status'))
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield DateTimeField::new('date', 'Date')->setRequired(true);
        yield TextField::new('status', 'Status')->setRequired(true);
        yield ImageField::new('screenshot', 'Screenshot')
            ->setUploadDir('public/uploads/screenshots')
            ->setBasePath('screenshots/')
            ->setFormTypeOption('upload_new', function (UploadedFile $file, string $uploadDir, string $fileName) {
                if (($extraDirs = dirname($fileName)) !== '.') {
                    $uploadDir .= $extraDirs;
                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir, 0750, true);
                    }
                }
                $file->move($uploadDir, $fileName);
            })
            ->setUploadedFileNamePattern('[year]/[month]/[day]/[slug]-[contenthash].[extension]');
        yield BooleanField::new('has_error', 'Has Error');
        yield TextareaField::new('error_description', 'Error description');
    }
}
