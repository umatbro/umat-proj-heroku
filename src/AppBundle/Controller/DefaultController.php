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
//      $connection = $this->get('database_connection');
//      $users= $connection->fetchAll('SELECT * FROM user');
//      $user = $users[0]['name'];
        return $this->render('mat/register.html.twig');
    }

    /**
     * @Route("/confirmation", name="confirm")
     */
    public function confirmAction(){
        $name = $_POST['name'];
        $password = $_POST['password'];
        $password = password_hash($password, PASSWORD_DEFAULT);
        $connection = $this->get('database_connection');
        $query = "INSERT INTO `user` (`name`, `password`) VALUES ( '".$name."', '".$password."')";
        $connection->query($query);
        unset($_POST['name']);
        unset($_POST['password']);

        return $this->render('mat/confirmation.html.twig', array(
            'imie' => $name
        ));
    }

    /**
     * display registered users
     * @Route("/display", name="display")
     */
    public function displayAction(){
        $conn = $this->get('database_connection');
        $users = $conn->fetchAll('SELECT * FROM user');
        foreach($users as $user){
                $names[] = $user['name'];
                $passwords[] = $user['password'];

        }
        $xd = $names[0];
        //$passwords = $users['password'];
        return $this->render('mat/display.html.twig', ['users' => $names, 'passwords' => $passwords]);
    }

}
