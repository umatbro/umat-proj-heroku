<?php

namespace AppBundle\Controller;

use AppBundle\Entity\OrderItem;
use AppBundle\Entity\Product;
use AppBundle\Entity\UserOrder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
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
    public function clearCard(){
        $session = $this->get('session');
        $session->remove('quantity');
        $session->remove('orderItems');
        return $this->redirect($this->generateUrl('homepage'));
    }


    /**
     * @Route("/confirm", name="confirmOrder")
     */
    public function confirmAction(){
        return $this->render('cart/confirm.html.twig');
    }

    /**
     * @Route("/submit", name="submitOrder")
     */
    public function submitAction()
    {
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

        $session->remove('orderItems');
        $session->remove('quantity');

        return $this->redirect($this->generateUrl('orderSummary', [
            "userOrderId" => $userOrder
        ]));
    }

    /**
     * @Route("/summary/{userOrderId}", name="orderSummary")
     */
    public function summaryAction($userOrderId){
        $int = intval(preg_replace('/[^0-9]+/', '', $userOrderId), 10);
        $em = $this -> getDoctrine() -> getManager();
        $userOrder = $em->find('AppBundle\Entity\UserOrder', $int);
        return $this->render('cart/order_summary.html.twig',[
            "userOrder" => $userOrder
        ]);
    }
}
