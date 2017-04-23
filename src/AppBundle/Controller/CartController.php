<?php

namespace AppBundle\Controller;

use AppBundle\Entity\OrderItem;
use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CartController
 * @package AppBundle\Controller
 *
 * @Route("/cart")
 */
class CartController extends Controller
{

    /**
     * @Route("/add-item/{productID}", name="addOrderItem")
     */
    public function addOrderItemAction($productID){
        //get product from DB
        $repository = $this->getDoctrine()->getRepository('AppBundle:Product');
        $product = $repository->find($productID);

        //set session and get session variables
        $session = $this->get('session');
        $orderItems = $session -> get('orderItems');

        //add new order to the list
        $orderItem = new OrderItem($product);
        $orderItems[] = $orderItem;
        $quantity = count($orderItems);

        //save session variables
        $session->set('quantity', $quantity);
        $session -> set('orderItems', $orderItems);

        return $this->redirect($this->generateUrl('homepage'));
    }

    /**
     * @Route("/clear",name="clearCart")
     */
    public function clearCard(){
        //if(isset($_SESSION['quantity'])) unset($_SESSION['quantity']);
        //if(isset($_SESSION['order-items'])) unset($_SESSION['order-items']);
        $session = $this->get('session');
        $session->remove('quantity');
        $session->remove('orderItems');
        return $this->redirect($this->generateUrl('homepage'));
    }
}
