<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * UserOrder
 *
 * @ORM\Table(name="user_order")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserOrderRepository")
 */
class UserOrder
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
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * @var bool
     *
     * @ORM\Column(name="payment_received", type="boolean")
     */
    private $paymentReceived;

    /**
     * @var int
     *
     * @ORM\Column(name="total_price", type="decimal", scale=2, precision=10)
     */
    private $totalPrice;


    /**
     * @ORM\OneToMany(targetEntity="OrderItem", mappedBy="userOrder")
     */
    private $orderItems;


    public function __construct()
    {
        $this-> orderItems = new ArrayCollection();
//        foreach($ordItems as $orderItem){
//            $this->orderItems->add($orderItem);
//        }
//        $this->totalPrice=0;
//        foreach($ordItems as $orderItem){
//            $this->totalPrice += $orderItem->getNumberOfProducts() * $orderItem->getProduct()->getDefaultPrice();
//        }
        $this->createdAt = new \DateTime();
        $this->status = false;
        $this->paymentReceived=false;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return "id".$this->getId();
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
     * @param \DateTime $createdAt
     *
     * @return UserOrder
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
     * Set status
     *
     * @param boolean $status
     *
     * @return UserOrder
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Add orderItem
     *
     * @param \AppBundle\Entity\OrderItem $orderItem
     *
     * @return UserOrder
     */
    public function addOrderItem(\AppBundle\Entity\OrderItem $orderItem)
    {
        $this->orderItems[] = $orderItem;

        return $this;
    }

    /**
     * Remove orderItem
     *
     * @param \AppBundle\Entity\OrderItem $orderItem
     */
    public function removeOrderItem(\AppBundle\Entity\OrderItem $orderItem)
    {
        $this->orderItems->removeElement($orderItem);
    }

    /**
     * Get orderItems
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrderItems()
    {
        return $this->orderItems;
    }

    /**
     * Set paymentReceived
     *
     * @param boolean $paymentReceived
     *
     * @return UserOrder
     */
    public function setPaymentReceived($paymentReceived)
    {
        $this->paymentReceived = $paymentReceived;

        return $this;
    }

    /**
     * Get paymentReceived
     *
     * @return boolean
     */
    public function getPaymentReceived()
    {
        return $this->paymentReceived;
    }

    /**
     * Set totalPrice
     *
     * @param integer $totalPrice
     *
     * @return UserOrder
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    /**
     * Get totalPrice
     *
     * @return integer
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }
}
