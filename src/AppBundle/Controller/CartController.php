<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
        if(!isset($_SESSION['quantity'])) $_SESSION['quantity'] = 0;
        $_SESSION['quantity']++;
        $session = $this->get('session');
        $session -> set('quantity', $_SESSION['quantity']);

        return $this->redirect($this->generateUrl('homepage'));
    }

    /**
     * @Route("/clear",name="clearCart")
     */
    public function clearCard(){
        if(isset($_SESSION['quantity'])) unset($_SESSION['quantity']);
        $session = $this->get('session');
        $session->remove('quantity');
        return $this->redirect($this->generateUrl('homepage'));
    }
}
