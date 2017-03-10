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
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/register", name="register")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(){
        return $this->render('mat/register.html.twig');
    }

    /**
     * @Route("/confirmation", name="confirm")
     */
    public function confirmAction(){
        $x = $_POST['name'];
        return $this->render('mat/confirmation.html.twig', array(
            'imie' => $x
        ));
    }

}
