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
		
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', ['products' => $products]);
    }

    /**
     * @Route("/test", name="test")
     */
    public function testAction(){
        $session = $this -> get('session');
        $orderItems = $session->get('orderItems');
        $em = $this->getDoctrine()->getManager();
        $usr= $this->get('security.token_storage')->getToken()->getUser();

        $repository = $this->getDoctrine()->getRepository('AppBundle:Product');
        $userOrder = new UserOrder();
        $totalPrice = 0;

        foreach($orderItems as $orderItem){
            $orderItem->setUser($usr);
            $product = $repository->find($orderItem->getProduct()->getId());
            $orderItem->setProduct($product);
            $category = $product->getCategory();
            $orderItem->getProduct()->setCategory($category);
            $userOrder->addOrderItem($orderItem);
            $totalPrice += ($orderItem -> getNumberOfProducts()) * ($orderItem -> getProduct() -> getDefaultPrice());
        }
        foreach($orderItems as $orderItem){
            $orderItem->setUserOrder($userOrder);
            $em->persist($orderItem);
        }
        $userOrder->setTotalPrice($totalPrice);
        $em->persist($userOrder);
        $em->flush();
        $em->clear();



        return $this->render('default/test.html.twig',["orderItems"=> $orderItems,
            "username"=> $usr->getUsername(),
            "category" => $category,
            "userOrder" => $userOrder
            ]);
    }


}
