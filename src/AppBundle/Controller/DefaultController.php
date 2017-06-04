<?php

namespace AppBundle\Controller;

use AppBundle\Entity\OrderItem;
use AppBundle\Entity\UserOrder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
		
		$em = $this -> getDoctrine() -> getManager();
        $products = $em->getRepository('AppBundle:Product')->findAll();
		
		foreach($products as $product){
			$productNames[] = $product-> getName();
		}
		
        return $this->render('default/index.html.twig', ['products' => $products]);
    }

    /**
     * @Route("/profile/orders", name="profile_orders")
     */
    public function profileOrdersAction(){
        $em = $this->getDoctrine()->getManager();
        $user= $this->get('security.token_storage')->getToken()->getUser();
        $orderItems = $em->getRepository('AppBundle\Entity\OrderItem') -> findBy([
            'user' => $user->getId()
        ]);

        $userOrders = [];
        $searched = [];
        foreach($orderItems as $item){
            $orderId = $item->getUserOrder()->getId();
            if(!in_array($orderId, $searched))
                $userOrders[] = $em->getRepository("AppBundle\Entity\UserOrder") -> find($orderId);
            $searched[] = $orderId;
        }

        return $this->render('@FOSUser/Profile/show_orders.html.twig',[
            'user' => $user,
            'orderItems' => $orderItems,
            'orders' => $userOrders
        ]);
    }
}
