<?php

namespace AppBundle\Controller;

use AppBundle\Entity\OrderItem;
use AppBundle\Entity\Product;
use AppBundle\Entity\UserOrder;
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
    public function addOrderItemAction($productID)
    {
        //get product from DB
        $repository = $this->getDoctrine()->getRepository('AppBundle:Product');
        $product = $repository->find($productID);

        //set session and get session variables
        $session = $this->get('session');
        $orderItems = $session->get('orderItems');

        //add new order to the list
        $orderItem = new OrderItem($product);

        $addNewUnique = true; //flag to determine if new item in cart is unique
        //search for repeating products and increase number of items in order
        if(is_array($orderItems)){
            foreach($orderItems as $ordit){
                if($orderItem->getProduct()->getId() == $ordit->getProduct()->getId()){
                    $ordit->addNumberOfProducts(1);
                    $addNewUnique = false; //set the flag
                    break; //if found one, no need to look further
                }
            }
        }

        //if new product is unique - add it do the list
        if($addNewUnique){
            $orderItems[] = $orderItem;
        }

        //count number of items in the cart
        $quantity = 0;
        if(is_array($orderItems)) {
            foreach ($orderItems as $ordit) {
                $quantity += $ordit->getNumberOfProducts();
            }
        }

        //save session variables
        $session->set('quantity', $quantity);
        $session -> set('orderItems', $orderItems);

        return $this->redirect($this->generateUrl('homepage'));
    }

    /**
     * @Route("/clear",name="clearCart")
     */
    public function clearCart(){
        $session = $this->get('session');
        $session->remove('quantity');
        $session->remove('orderItems');
        return $this->redirect($this->generateUrl('homepage'));
    }


    /**
     * @Route("/confirm", name="confirmOrder")
     */
    public function confirmAction(){
        $session = $this->get('session');
        $orderItems = $session->get('orderItems');


        return $this->render('cart/confirm.html.twig');
    }

    /**
     * @Route("/submit", name="submitOrder")
     */
    public function submitAction()
    {
//        $session = $this->get('session');
//        //$auth_checker = $this->get('security.authorization_checker');
//        // Get our Token (representing the currently logged in user)
//        $token = $this->get('security.token_storage')->getToken();
//
//        // Get our user from that token
//        $user = $token->getUser();

        $session = $this->get('session');
        $orderItems = $session->get('orderItems');
        $user = $this->getUser(); //->getUsername();

        $userOrder = new UserOrder($orderItems, $user);

        if ($user) {
            //create UserOrder object using orderItems stored in session
            $userOrder = new UserOrder($orderItems, $user);
            //get db connection
            $em = $this->getDoctrine()->getManager();
            $em->persist($userOrder);
            $em->flush();
            $message= "Twoje zamówienie zostało zapisane";
        } else{
            $message = "Nie jesteś zalogowany";
        }

        //after adding order to database, remove it from session
        $session->remove('orderItems');
        $session->remove('quantity');
        $session->set('message', $message);


        return $this->redirect($this->generateUrl('confirmOrder'));
    }
}
