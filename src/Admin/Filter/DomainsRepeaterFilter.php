<?php
namespace App\Admin\Filter;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Filter\FilterInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FilterDataDto;
use EasyCorp\Bundle\EasyAdminBundle\Filter\FilterTrait;
use EasyCorp\Bundle\EasyAdminBundle\Form\Filter\Type\TextFilterType;

class DomainsRepeaterFilter implements FilterInterface
{

   use FilterTrait;

   protected $tables;
   protected $joinClass;

   public static function new(string $propertyName, $label = null): self
   {
      $filter = (new self());
      $tables = explode('.', $propertyName);

      return $filter
         ->setFilterFqcn(__CLASS__)
         ->setTables($tables)
         ->setProperty(str_replace('.','_',$propertyName))
         ->setLabel($label)
         ->setFormType(TextFilterType::class)
         ->setFormTypeOption('translation_domain', 'EasyAdminBundle');
   }

   public function setTables($tables)
   {
      $this->tables = $tables;
      return $this;
   }

   public function apply(QueryBuilder $queryBuilder, FilterDataDto $filterDataDto, ?FieldDto $fieldDto, EntityDto $entityDto): void
   {
      $comparison = $filterDataDto->getComparison();
      $parameterName = $filterDataDto->getParameterName();
      $parameterValue = $filterDataDto->getValue();

      $em = $queryBuilder->getEntityManager();
      
      $table = "entity";
      for ($count=0; $count<count($this->tables)-1; $count++) {
         $idTable = substr($this->tables[$count], 0, 1) . "_" . $count;
         $queryBuilder->join($table . '.' . $this->tables[$count], $idTable);
         $table = $idTable;
      }
      $property = $this->tables[$count];
 
      $queryBuilder
         ->andWhere(sprintf('%s.%s %s :%s', $table, $property, $comparison, $parameterName))
         ->setParameter($parameterName, $parameterValue);
   }
}