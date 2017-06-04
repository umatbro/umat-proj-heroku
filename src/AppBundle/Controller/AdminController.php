<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
/**
 * admin controller
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="admin")
     */
    public function adminAction()
    {
        return $this->render('AppBundle:Admin:admin.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/users", name="admin_view_users")
     */
    public function viewUsersAction(){
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->findAll();

        return $this->render('AppBundle:Admin:users.html.twig', [
            "users" => $users
        ]);
    }

}
