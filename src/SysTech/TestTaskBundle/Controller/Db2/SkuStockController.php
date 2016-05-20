<?php

namespace SysTech\TestTaskBundle\Controller\Db2;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\VarDumper\VarDumper;
use SysTech\TestTaskBundle\Entity\Db2\SkuStock;
use SysTech\TestTaskBundle\Form\Db2\SkuStockType;

/**
 * SkuStock controller.
 *
 * @Route("/db2/skustock")
 */
class SkuStockController extends Controller
{
    /**
     * Lists all SkuStock entities.
     *
     * @Route("/", name="/db2/skustock_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager('db2');
        $skuStocks = $em->getRepository('BaseSynchronizeBundle:SkuStock')->findAll();

        return $this->render('BaseSynchronizeBundle:Db2:Skustock/index.html.twig', array(
            'skuStocks' => $skuStocks,
        ));
    }

    /**
     * Creates a new SkuStock entity.
     *
     * @Route("/new", name="/db2/skustock_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $skuStock = new SkuStock();
        $form = $this->createForm('SysTech\TestTaskBundle\Form\Db2\SkuStockType', $skuStock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager('db2');
            $skuStock->setCreatedAt(time());
            $skuStock->setModifiedAt(time());
            $em->persist($skuStock);
            $em->flush();

            return $this->redirectToRoute('/db2/skustock_show', array('id' => $skuStock->getId()));
        }

        return $this->render('BaseSynchronizeBundle:Db2:Skustock/new.html.twig', array(
            'skuStock' => $skuStock,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a SkuStock entity.
     *
     * @Route("/{id}", name="/db2/skustock_show")
     * @Method("GET")
     */
    public function showAction(SkuStock $skuStock)
    {
        $deleteForm = $this->createDeleteForm($skuStock);

        return $this->render('BaseSynchronizeBundle:Db2:Skustock/show.html.twig', array(
            'skuStock' => $skuStock,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing SkuStock entity.
     *
     * @Route("/{id}/edit", name="/db2/skustock_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SkuStock $skuStock)
    {
        $deleteForm = $this->createDeleteForm($skuStock);
        $editForm = $this->createForm('SysTech\TestTaskBundle\Form\Db2\SkuStockType', $skuStock);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager('db2');
            $skuStock->setModifiedAt(time());
            $em->persist($skuStock);
            $em->flush();

            return $this->redirectToRoute('/db2/skustock_edit', array('id' => $skuStock->getId()));
        }

        return $this->render('BaseSynchronizeBundle:Db2:Skustock/edit.html.twig', array(
            'skuStock' => $skuStock,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a SkuStock entity.
     *
     * @Route("/{id}", name="/db2/skustock_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SkuStock $skuStock)
    {
        $form = $this->createDeleteForm($skuStock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager('db2');
            $em->remove($skuStock);
            $em->flush();
        }

        return $this->redirectToRoute('/db2/skustock_index');
    }

    /**
     * Creates a form to delete a SkuStock entity.
     *
     * @param SkuStock $skuStock The SkuStock entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SkuStock $skuStock)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('/db2/skustock_delete', array('id' => $skuStock->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
