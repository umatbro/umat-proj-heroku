<?php

namespace AppBundle\Controller;

use AppBundle\Entity\OrderItem;
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
     * @Route("/add-order-item/{productID}", name="addOrderItem")
     */
    public function addOrderItemAction($productID){
//        $session = $this->get('session');
//        $session->set('quantity');

        $em = $this -> getDoctrine() -> getManager();
        $products = $em->getRepository('AppBundle:Product')->findAll();

        foreach($products as $product){
            $productNames[] = $product-> getName();
        }


        if(!isset($_SESSION['quantity'])) $_SESSION['quantity'] = 1;
        $_SESSION['quantity']++;
        $session = $this->get('session');
        $session -> set('filter', array(
            'quantity' => $_SESSION['quantity']
        ));
        return $this->render('default/index.html.twig', ['products' => $products]);
    }

    /**
     * @Route("/clear-card",name="clearCard")
     */
    public function clearCard(){
        $em = $this -> getDoctrine() -> getManager();
        $products = $em->getRepository('AppBundle:Product')->findAll();

        foreach($products as $product) {
            $productNames[] = $product->getName();
        }

        if(isset($_SESSION['quantity'])) ($_SESSION['quantity'] = 0);
        $session = $this->get('session');
        $session -> set('filter', array(
            'quantity' => $_SESSION['quantity']
        ));

        return $this->render('default/index.html.twig', ['products'=>$products]);
    }
}
