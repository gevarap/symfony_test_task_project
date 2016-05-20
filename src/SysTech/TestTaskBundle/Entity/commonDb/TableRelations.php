<?php
/**
 * Created by PhpStorm.
 * User: Gev
 * Date: 15.05.2016
 * Time: 1:39
 */

namespace SysTech\TestTaskBundle\Entity\commonDb;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class TableRelations
 * @ORM\Entity(repositoryClass="SysTech\TestTaskBundle\Entity\commonDb\Repository\TableRelationsRepository")
 * @ORM\Table(name="TableRelations")
 */
class TableRelations {
  /**
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   * @ORM\OneToMany(targetEntity="Mapping", mappedBy="relationId")
   */
  private $id;


  /**
   * @ORM\Column(type="string")
   */
  private $sourceBase;

  /**
   * @ORM\Column(type="string")
   */
  private $targetBase;

  /**
   * @ORM\Column(type="string")
   */
  private $sourceTable;

  /**
   * @ORM\Column(type="string")
   */
  private $targetTable;

  /**
   * @ORM\Column(type="string")
   */
  private $sourceEntity;

  /**
   * @ORM\Column(type="string")
   */
  private $targetEntity;

  /**
   * @ORM\Column(type="string")
   */
  private $sourceField;

  /**
   * @ORM\Column(type="string")
   */
  private $targetField;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set sourceBase
     *
     * @param string $sourceBase
     *
     * @return TableRelations
     */
    public function setSourceBase($sourceBase)
    {
        $this->sourceBase = $sourceBase;

        return $this;
    }

    /**
     * Get sourceBase
     *
     * @return string
     */
    public function getSourceBase()
    {
        return $this->sourceBase;
    }

    /**
     * Set targetBase
     *
     * @param string $targetBase
     *
     * @return TableRelations
     */
    public function setTargetBase($targetBase)
    {
        $this->targetBase = $targetBase;

        return $this;
    }

    /**
     * Get targetBase
     *
     * @return string
     */
    public function getTargetBase()
    {
        return $this->targetBase;
    }

    /**
     * Set sourceTable
     *
     * @param string $sourceTable
     *
     * @return TableRelations
     */
    public function setSourceTable($sourceTable)
    {
        $this->sourceTable = $sourceTable;

        return $this;
    }

    /**
     * Get sourceTable
     *
     * @return string
     */
    public function getSourceTable()
    {
        return $this->sourceTable;
    }

    /**
     * Set targetTable
     *
     * @param string $targetTable
     *
     * @return TableRelations
     */
    public function setTargetTable($targetTable)
    {
        $this->targetTable = $targetTable;

        return $this;
    }

    /**
     * Get targetTable
     *
     * @return string
     */
    public function getTargetTable()
    {
        return $this->targetTable;
    }

    /**
     * Set sourceField
     *
     * @param string $sourceField
     *
     * @return TableRelations
     */
    public function setSourceField($sourceField)
    {
        $this->sourceField = $sourceField;

        return $this;
    }

    /**
     * Get sourceField
     *
     * @return string
     */
    public function getSourceField()
    {
        return $this->sourceField;
    }

    /**
     * Set targetField
     *
     * @param string $targetField
     *
     * @return TableRelations
     */
    public function setTargetField($targetField)
    {
        $this->targetField = $targetField;

        return $this;
    }

    /**
     * Get targetField
     *
     * @return string
     */
    public function getTargetField()
    {
        return $this->targetField;
    }

    /**
     * Set sourceEntity
     *
     * @param string $sourceEntity
     *
     * @return TableRelations
     */
    public function setSourceEntity($sourceEntity)
    {
        $this->sourceEntity = $sourceEntity;

        return $this;
    }

    /**
     * Get sourceEntity
     *
     * @return string
     */
    public function getSourceEntity()
    {
        return $this->sourceEntity;
    }

    /**
     * Set targetEntity
     *
     * @param string $targetEntity
     *
     * @return TableRelations
     */
    public function setTargetEntity($targetEntity)
    {
        $this->targetEntity = $targetEntity;

        return $this;
    }

    /**
     * Get targetEntity
     *
     * @return string
     */
    public function getTargetEntity()
    {
        return $this->targetEntity;
    }
}
