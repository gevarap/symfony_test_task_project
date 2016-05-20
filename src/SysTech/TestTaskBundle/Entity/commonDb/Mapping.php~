<?php


namespace SysTech\TestTaskBundle\Entity\commonDb;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="SysTech\TestTaskBundle\Entity\commonDb\Repository\MappingRepository")
 * @ORM\Table(name="Mapping")
 */
class Mapping {

  /**
   * @ORM\Column(type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;


  /**
   * @ORM\ManyToOne(targetEntity="TableRelations", inversedBy="id")
   * @ORM\JoinColumn(name="relation_id", onDelete="CASCADE")
   */
  private $relationId;

  /**
   * @ORM\Column(type="integer")
   */
  private $firstId;

  /**
   * @ORM\Column(type="integer")
   */
  private $secondId;

  /**
   * @ORM\Column(type="string")
   */
  private $action;

  /**
   * @ORM\Column(type="integer")
   */
  private $lastChangedTime;

  /**
   * Get id
   *
   * @return integer
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set firstId
   *
   * @param integer $firstId
   *
   * @return Mapping
   */
  public function setFirstId($firstId) {
    $this->firstId = $firstId;

    return $this;
  }

  /**
   * Get firstId
   *
   * @return integer
   */
  public function getFirstId() {
    return $this->firstId;
  }

  /**
   * Set secondId
   *
   * @param integer $secondId
   *
   * @return Mapping
   */
  public function setSecondId($secondId) {
    $this->secondId = $secondId;

    return $this;
  }

  /**
   * Get secondId
   *
   * @return integer
   */
  public function getSecondId() {
    return $this->secondId;
  }

  /**
   * Set action
   *
   * @param string $action
   *
   * @return Mapping
   */
  public function setAction($action) {
    $this->action = $action;

    return $this;
  }

  /**
   * Get action
   *
   * @return string
   */
  public function getAction() {
    return $this->action;
  }

  /**
   * Set lastChangedTime
   *
   * @param integer $lastChangedTime
   *
   * @return Mapping
   */
  public function setLastChangedTime($lastChangedTime) {
    $this->lastChangedTime = $lastChangedTime;

    return $this;
  }

  /**
   * Get lastChangedTime
   *
   * @return integer
   */
  public function getLastChangedTime() {
    return $this->lastChangedTime;
  }

  /**
   * Set relationId
   *
   * @param \SysTech\TestTaskBundle\Entity\commonDb\TableRelations $relationId
   *
   * @return Mapping
   */
  public function setRelationId(TableRelations $relationId = NULL) {
    $this->relationId = $relationId;

    return $this;
  }

  /**
   * Get relationId
   *
   * @return \SysTech\TestTaskBundle\Entity\commonDb\TableRelations
   */
  public function getRelationId() {
    return $this->relationId;
  }
}
