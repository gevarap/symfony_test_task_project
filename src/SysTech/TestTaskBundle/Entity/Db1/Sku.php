<?php

namespace SysTech\TestTaskBundle\Entity\Db1;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sku
 *
 * @ORM\Table(name="sku")
 * @ORM\Entity(repositoryClass="SysTech\TestTaskBundle\Entity\Db1\Repository\SkuRepository")
 */
class Sku
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="integer")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modifiedAt", type="integer")
     */
    private $modifiedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="stock", type="integer", nullable=true)
     */
    private $stock;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set createdAt
     *
     * @param integer $createdAt
     *
     * @return Sku
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
     * Set modifiedAt
     *
     * @param integer $modifiedAt
     *
     * @return Sku
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
     * @return Sku
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

    /**
     * Set stock
     *
     * @param integer $stock
     *
     * @return Sku
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return int
     */
    public function getStock()
    {
        return $this->stock;
    }
}
