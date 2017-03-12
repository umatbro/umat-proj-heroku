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
      $connection = $this->get('database_connection');
      $users= $connection->fetchAll('SELECT * FROM user');
      $user = $users[0]['name'];
        return $this->render('mat/register.html.twig', ['user' => $user]);
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
