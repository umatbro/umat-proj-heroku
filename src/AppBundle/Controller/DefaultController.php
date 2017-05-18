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
    //

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/test", name="test")
     */
    public function testAction(){
        $session = $this->get('session');
        $orderItems = $session->get('orderItems');
        $user = $this->getUser(); //->getUsername();

        $userOrder = new UserOrder($orderItems, $user);

        $orderItemsFromUserOrder = $userOrder->getOrderItems();

        // TODO flush orderItems, not userOrder
        //persist objects to database
        $em = $this->getDoctrine()->getManager();
        $em -> merge($userOrder);
        foreach($orderItemsFromUserOrder as $ordit){
            $em->merge($ordit);
        }

        $em->flush();

        return $this->render("default/test.html.twig", ['orderItems' => $orderItemsFromUserOrder, 'username' =>$user,'userOrder' => $userOrder]);
    }

}
