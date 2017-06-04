<?php

namespace AppBundle\Controller;

use AppBundle\Entity\UserOrder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Userorder controller.
 *
 * @Route("admin/orders")
 */
class UserOrderController extends Controller
{
    /**
     * Lists all userOrder entities.
     *
     * @Route("/", name="admin_view_orders")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $userOrders = $em->getRepository('AppBundle:UserOrder')->findAll();

        return $this->render('AppBundle:Admin:orders.html.twig', array(
            'orders' => $userOrders,
        ));
    }

//    /**
//     * Creates a new userOrder entity.
//     *
//     * @Route("/new", name="admin_orders_new")
//     * @Method({"GET", "POST"})
//     */
//    public function newAction(Request $request)
//    {
//        $userOrder = new Userorder();
//        $form = $this->createForm('AppBundle\Form\UserOrderType', $userOrder);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($userOrder);
//            $em->flush($userOrder);
//
//            return $this->redirectToRoute('admin_orders_show', array('id' => $userOrder->getId()));
//        }
//
//        return $this->render('userorder/new.html.twig', array(
//            'userOrder' => $userOrder,
//            'form' => $form->createView(),
//        ));
//    }

    /**
     * Finds and displays a userOrder entity.
     *
     * @Route("/{id}", name="admin_orders_show")
     * @Method("GET")
     */
    public function showAction(UserOrder $userOrder)
    {
        $deleteForm = $this->createDeleteForm($userOrder);

        return $this->render('userorder/show.html.twig', array(
            'userOrder' => $userOrder,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing userOrder entity.
     *
     * @Route("/{id}/edit", name="admin_orders_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, UserOrder $userOrder)
    {
        $deleteForm = $this->createDeleteForm($userOrder);
        $editForm = $this->createForm('AppBundle\Form\UserOrderType', $userOrder);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_orders_edit', array('id' => $userOrder->getId()));
        }

        return $this->render('userorder/edit.html.twig', array(
            'userOrder' => $userOrder,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a userOrder entity.
     *
     * @Route("/{id}", name="admin_orders_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, UserOrder $userOrder)
    {
        $form = $this->createDeleteForm($userOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($userOrder);
            $em->flush($userOrder);
        }

        return $this->redirectToRoute('admin_orders_index');
    }

    /**
     * Creates a form to delete a userOrder entity.
     *
     * @param UserOrder $userOrder The userOrder entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UserOrder $userOrder)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_orders_delete', array('id' => $userOrder->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
