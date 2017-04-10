<?php

namespace AppBundle\Controller;

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
		$products = $em -> find('AppBundle:Product');
		
		foreach($products as $product){
			$productNames[] = $product-> getName();
		}
		
		
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', ['productNames' => $productNames]);
    }
    //
}
