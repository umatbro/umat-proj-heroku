<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderItem
 *
 * @ORM\Table(name="order_item")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrderItemRepository")
 */
class OrderItem
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
     * @var int
     *
     * @ORM\Column(name="numberOfProducts", type="integer")
     */
    private $numberOfProducts;

    /**
     * @ORM\OneToOne(targetEntity="Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="UserOrder", inversedBy="orderItems")
     * @ORM\JoinColumn(name="userorder_id", referencedColumnName="id")
     */
    private $userOrder;

    public function __construct(\AppBundle\Entity\Product $product)
    {
        $this->setProduct($product);
        $this->setNumberOfProducts(1);
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
     * Set numberOfProducts
     *
     * @param integer $numberOfProducts
     *
     * @return OrderItem
     */
    public function setNumberOfProducts($numberOfProducts)
    {
        $this->numberOfProducts = $numberOfProducts;

        return $this;
    }

    /**
     * Set numberOfProducts to desired value
     * @param $value to which numberOfProducts will be changed
     * @return $this
     */
    public function addNumberOfProducts($value){
        $this->numberOfProducts += $value;
        return $this;
    }

    /**
     * Get numberOfProducts
     *
     * @return int
     */
    public function getNumberOfProducts()
    {
        return $this->numberOfProducts;
    }

    /**
     * Set product
     *
     * @param \AppBundle\Entity\Product $product
     *
     * @return OrderItem
     */
    public function setProduct(\AppBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \AppBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set userOrder
     *
     * @param \AppBundle\Entity\UserOrder $userOrder
     *
     * @return OrderItem
     */
    public function setUserOrder(\AppBundle\Entity\UserOrder $userOrder = null)
    {
        $this->userOrder = $userOrder;

        return $this;
    }

    /**
     * Get userOrder
     *
     * @return \AppBundle\Entity\UserOrder
     */
    public function getUserOrder()
    {
        return $this->userOrder;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        $result = $this->getProduct()->getName();
        $result .= " (".$this->getNumberOfProducts().")";
        return $result;
    }
}
