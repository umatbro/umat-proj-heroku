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
        if(!isset($_SESSION['quantity'])) $_SESSION['quantity'] = 0;
        $_SESSION['quantity']++;
        $session = $this->get('session');
        $session -> set('quantity', $_SESSION['quantity']);

        return $this->redirect($this->generateUrl('homepage'));
    }

    /**
     * @Route("/clear-card",name="clearCart")
     */
    public function clearCard(){
        if(isset($_SESSION['quantity'])) unset($_SESSION['quantity']);
        $session = $this->get('session');
        $session->remove('quantity');
        return $this->redirect($this->generateUrl('homepage'));
    }
}
