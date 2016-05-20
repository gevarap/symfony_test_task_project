<?php

namespace SysTech\TestTaskBundle\Controller\Db2;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use SysTech\TestTaskBundle\Entity\Db2\Outlet;
use SysTech\TestTaskBundle\Form\Db2\OutletType;

/**
 * Outlet controller.
 *
 * @Route("/db2/outlet")
 */
class OutletController extends Controller
{
    /**
     * Lists all Outlet entities.
     *
     * @Route("/", name="/db2/outlet_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager('db2');

        $outlets = $em->getRepository('BaseSynchronizeBundle:Outlet')->findAll();

        return $this->render('BaseSynchronizeBundle:Db2:Outlet/index.html.twig', array(
            'outlets' => $outlets,
        ));
    }

    /**
     * Creates a new Outlet entity.
     *
     * @Route("/new", name="/db2/outlet_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $outlet = new Outlet();
        $form = $this->createForm('SysTech\TestTaskBundle\Form\Db2\OutletType', $outlet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager('db2');
            $outlet->setCreatedAt(time());
            $outlet->setModifiedAt(time());
            $em->persist($outlet);
            $em->flush();

            return $this->redirectToRoute('/db2/outlet_show', array('id' => $outlet->getId()));
        }

        return $this->render('BaseSynchronizeBundle:Db2:Outlet/new.html.twig', array(
            'outlet' => $outlet,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Outlet entity.
     *
     * @Route("/{id}", name="/db2/outlet_show")
     * @Method("GET")
     */
    public function showAction(Outlet $outlet)
    {
        $deleteForm = $this->createDeleteForm($outlet);

        return $this->render('BaseSynchronizeBundle:Db2:Outlet/show.html.twig', array(
            'outlet' => $outlet,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Outlet entity.
     *
     * @Route("/{id}/edit", name="/db2/outlet_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Outlet $outlet)
    {
        $deleteForm = $this->createDeleteForm($outlet);
        $editForm = $this->createForm('SysTech\TestTaskBundle\Form\Db2\OutletType', $outlet);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager('db2');
            $outlet->setModifiedAt(time());
            $em->persist($outlet);
            $em->flush();

            return $this->redirectToRoute('/db2/outlet_edit', array('id' => $outlet->getId()));
        }

        return $this->render('BaseSynchronizeBundle:Db2:Outlet/edit.html.twig', array(
            'outlet' => $outlet,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Outlet entity.
     *
     * @Route("/{id}", name="/db2/outlet_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Outlet $outlet)
    {
        $form = $this->createDeleteForm($outlet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager('db2');
            $em->remove($outlet);
            $em->flush();
        }

        return $this->redirectToRoute('/db2/outlet_index');
    }

    /**
     * Creates a form to delete a Outlet entity.
     *
     * @param Outlet $outlet The Outlet entity
     *
     * @return \Symfony\Component\Form\
     */
    private function createDeleteForm(Outlet $outlet)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('/db2/outlet_delete', array('id' => $outlet->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
