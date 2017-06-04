<?php

namespace AppBundle\Controller;

use AppBundle\Entity\UserOrder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Userorder controller.
 *
 * @Route("admin/orders")
 */
class UserOrderController extends Controller
{
    /**
     * Lists all userOrder entities.
     *
     * @Route("/", name="admin_view_orders")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $userOrders = $em->getRepository('AppBundle:UserOrder')->findAll();

        return $this->render('AppBundle:Admin:orders.html.twig', array(
            'orders' => $userOrders,
            'user' => null
            ));
    }

    /**
     * @Route("/{userId}", name="admin_view_user_orders")
     */
    public function viewUserOrdersAction($userId){
        $em = $this->getDoctrine()->getManager();
        $orderItems = $orderItems = $em->getRepository('AppBundle\Entity\OrderItem') -> findBy([
            'user' => $userId
        ]);

        $user = $em->getRepository('AppBundle:User')->find($userId);
        $userOrders = [];
        $searched = [];
        foreach($orderItems as $item){
            $orderId = $item->getUserOrder()->getId();
            if(!in_array($orderId, $searched))
                $userOrders[] = $em->getRepository("AppBundle\Entity\UserOrder") -> find($orderId);
            $searched[] = $orderId;
        }
        return $this->render('AppBundle:Admin:orders.html.twig', array(
            'orders' => $userOrders,
            'user' => $user
        ));
    }

    /**
     * @Route("/details/{id}", name="admin_order_details")
     */
    public function detailsAction($id){
        $em = $this -> getDoctrine() -> getManager();
        $orderItems = $em->getRepository('AppBundle\Entity\OrderItem') -> findBy([
            'userOrder' => $id
        ]);
        $userOrder = $em->getRepository('AppBundle\Entity\UserOrder') -> find($id);
        return $this->render('AppBundle:Admin:order_details.html.twig', [
           "orderItems" => $orderItems,
            "userOrder" => $userOrder
        ]);
    }

    /**
     * @Route("/change-order-payment-status/{id}", name="admin_change_payment_status")
     */
    public function changePaymentStatusAction($id){
        $em = $this->getDoctrine()->getManager();
        $userOrder = $em->getRepository('AppBundle\Entity\UserOrder') -> find($id);
        $userOrder->setPaymentReceived(!($userOrder->getPaymentReceived()));
        $em->persist($userOrder);
        $em->flush();
        return $this->redirect($this->generateUrl('admin_order_details',[
            'id' => $id
        ]));
    }

    /**
     * @Route("/change-delivery-status/{id}", name="admin_change_delivery_status")
     */
    public function changeDeliveryStatusAction($id){
        $em = $this->getDoctrine()->getManager();
        $userOrder = $em->getRepository('AppBundle\Entity\UserOrder') -> find($id);
        $userOrder->setStatus(!($userOrder->getStatus()));
        $em->persist($userOrder);
        $em->flush();
        return $this->redirect($this->generateUrl('admin_order_details',[
            'id' => $id
        ]));
    }
}
