<?php
/**
 * Created by PhpStorm.
 * User: Gev
 * Date: 14.05.2016
 * Time: 23:46
 */


namespace SysTech\TestTaskBundle\Entity\Db2;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="SysTech\TestTaskBundle\Entity\Db2\Repository\EmployeeRepository")
 * @ORM\Table(name="employee")
 */
class Employee
{
  /**
   * @ORM\Column(type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @ORM\Column(type="integer")
   */
  private $createdAt;

  /**
   * @ORM\Column(type="integer")
   */
  private $modifiedAt;

  /**
   * @ORM\Column(type="string")
   */
  private $name;

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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Employee
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return integer
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set modifedAt
     *
     * @param integer $modifiedAt
     *
     * @return Employee
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    /**
     * Get modifiedAt
     *
     * @return integer
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Employee
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
