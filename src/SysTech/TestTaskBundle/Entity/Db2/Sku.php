<?php

namespace SysTech\TestTaskBundle\Entity\Db2;

use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Sku
 *
 * @ORM\Table(name="sku")
 * @ORM\Entity(repositoryClass="SysTech\TestTaskBundle\Entity\Db2\Repository\SkuRepository")
 */
class Sku
{
    /**
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\OneToMany(targetEntity="SkuStock", mappedBy="skuId", cascade={"persist", "remove"})
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


    public function __toString() {

        return $this->getName();

    }

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
     * @return \DateTime
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
     * @return integer $modifiedAt
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
}
