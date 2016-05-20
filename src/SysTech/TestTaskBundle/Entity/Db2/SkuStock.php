<?php

namespace SysTech\TestTaskBundle\Entity\Db2;

use Doctrine\ORM\Mapping as ORM;

/**
 * SkuStock
 *
 * @ORM\Table(name="sku_stock")
 * @ORM\Entity(repositoryClass="SysTech\TestTaskBundle\Entity\Db2\Repository\SkuStockRepository")
 */
class SkuStock
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
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
     * @var int
     * @ORM\ManyToOne(targetEntity="Sku", inversedBy="id")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $skuId;

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
     * @return SkuStock
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
     * @return SkuStock
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
     * Set skuId
     *
     * @param integer $skuId
     *
     * @return SkuStock
     */
    public function setSkuId($skuId)
    {
        $this->skuId = $skuId;

        return $this;
    }

    /**
     * Get skuId
     *
     * @return int
     */
    public function getSkuId()
    {
        return $this->skuId;
    }

    /**
     * Set stock
     *
     * @param integer $stock
     *
     * @return SkuStock
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
