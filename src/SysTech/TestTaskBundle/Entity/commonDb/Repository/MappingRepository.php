<?php
/**
 * Created by PhpStorm.
 * User: Gev
 * Date: 15.05.2016
 * Time: 0:37
 */
namespace SysTech\TestTaskBundle\Entity\commonDb\Repository;


use Doctrine\ORM\EntityRepository;
use Proxies\__CG__\SysTech\TestTaskBundle\Entity\commonDb\Mapping;

class MappingRepository extends EntityRepository {

  public function findAllRelationKeyedIds() {
    $return = array();
    foreach ($this->findAll() as $mapping) {
      /** @var Mapping $mapping */
      $return[$mapping->getRelationId()->getId()]['db1_table_mapped_ids'][$mapping->getFirstId()] = $mapping->getSecondId();
      $return[$mapping->getRelationId()->getId()]['db2_table_mapped_ids'][$mapping->getSecondId()] = $mapping->getFirstId();
    }
    return $return;
  }
}