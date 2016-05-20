<?php

namespace SysTech\TestTaskBundle\Controller\Db2;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\VarDumper\VarDumper;
use SysTech\TestTaskBundle\Entity\Db2\Sku;
use SysTech\TestTaskBundle\Form\Db2\SkuType;

/**
 * Sku controller.
 *
 * @Route("/db2/sku")
 */
class SkuController extends Controller
{
    /**
     * Lists all Sku entities.
     *
     * @Route("/", name="/db2/sku_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager('db2');

        $skus = $em->getRepository('BaseSynchronizeBundle:Sku')->findAll();

        return $this->render('BaseSynchronizeBundle:Db2:Sku/index.html.twig', array(
            'skus' => $skus,
        ));
    }

    /**
     * Creates a new Sku entity.
     *
     * @Route("/new", name="/db2/sku_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $sku = new Sku();
        $form = $this->createForm('SysTech\TestTaskBundle\Form\Db2\SkuType', $sku);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager('db2');
            $sku->setCreatedAt(time());
            $sku->setModifiedAt(time());
            $em->persist($sku);
            $em->flush();

            return $this->redirectToRoute('/db2/sku_show', array('id' => $sku->getId()));
        }

        return $this->render('BaseSynchronizeBundle:Db2:Sku/new.html.twig', array(
            'sku' => $sku,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Sku entity.
     *
     * @Route("/{id}", name="/db2/sku_show")
     * @Method("GET")
     */
    public function showAction(Sku $sku)
    {
        $deleteForm = $this->createDeleteForm($sku);

        return $this->render('BaseSynchronizeBundle:Db2:Sku/show.html.twig', array(
            'sku' => $sku,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Sku entity.
     *
     * @Route("/{id}/edit", name="/db2/sku_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Sku $sku)
    {
        $deleteForm = $this->createDeleteForm($sku);
        $editForm = $this->createForm('SysTech\TestTaskBundle\Form\Db2\SkuType', $sku);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager('db2');
            $sku->setModifiedAt(time());
            $em->persist($sku);
            $em->flush();

            return $this->redirectToRoute('/db2/sku_edit', array('id' => $sku->getId()));
        }

        return $this->render('BaseSynchronizeBundle:Db2:Sku/edit.html.twig', array(
            'sku' => $sku,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Sku entity.
     *
     * @Route("/{id}", name="/db2/sku_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Sku $sku)
    {
        $form = $this->createDeleteForm($sku);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager('db2');
            $em->remove($sku);
            $em->flush();
        }

        return $this->redirectToRoute('/db2/sku_index');
    }

    /**
     * Creates a form to delete a Sku entity.
     *
     * @param Sku $sku The Sku entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Sku $sku)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('/db2/sku_delete', array('id' => $sku->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
