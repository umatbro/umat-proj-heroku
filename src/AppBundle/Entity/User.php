<?php // src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="UserOrder", mappedBy="user")
     */
    private $userOrders;

    public function __construct()
    {
        parent::__construct();
    // your own logic
        $this->userOrders = new ArrayCollection();
    }

    /**
     * Add userOrder
     *
     * @param \AppBundle\Entity\UserOrder $userOrder
     *
     * @return User
     */
    public function addUserOrder(\AppBundle\Entity\UserOrder $userOrder)
    {
        $this->userOrders[] = $userOrder;

        return $this;
    }

    /**
     * Remove userOrder
     *
     * @param \AppBundle\Entity\UserOrder $userOrder
     */
    public function removeUserOrder(\AppBundle\Entity\UserOrder $userOrder)
    {
        $this->userOrders->removeElement($userOrder);
    }

    /**
     * Get userOrders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserOrders()
    {
        return $this->userOrders;
    }
}
