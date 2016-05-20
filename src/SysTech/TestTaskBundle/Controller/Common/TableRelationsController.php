<?php

namespace SysTech\TestTaskBundle\Controller\Common;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use SysTech\TestTaskBundle\Entity\commonDb\TableRelations;
use SysTech\TestTaskBundle\Form\Common\TableRelationsType;

/**
 * TableRelations controller.
 *
 * @Route("/common/tablerelations")
 */
class TableRelationsController extends Controller
{
    /**
     * Lists all TableRelations entities.
     *
     * @Route("/", name="/common/tablerelations_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager('commonDb');

        $tableRelations = $em->getRepository('BaseSynchronizeBundle:TableRelations')->findAll();

        return $this->render('BaseSynchronizeBundle:Common:TableRelation/index.html.twig', array(
            'tableRelations' => $tableRelations,
        ));
    }

    /**
     * Creates a new TableRelations entity.
     *
     * @Route("/new", name="/common/tablerelations_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tableRelation = new TableRelations();
        $form = $this->createForm(TableRelationsType::class, $tableRelation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager('commonDb');
            $tableRelation->setSourceBase('db1');
            $tableRelation->setTargetBase('db2');
            $em->persist($tableRelation);
            $em->flush();

            return $this->redirectToRoute('/common/tablerelations_show', array('id' => $tableRelation->getId()));
        }

        return $this->render('BaseSynchronizeBundle:Common:TableRelation/new.html.twig', array(
            'tableRelation' => $tableRelation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TableRelations entity.
     *
     * @Route("/{id}", name="/common/tablerelations_show")
     * @Method("GET")
     */
    public function showAction(TableRelations $tableRelation)
    {
        $deleteForm = $this->createDeleteForm($tableRelation);

        return $this->render('BaseSynchronizeBundle:Common:TableRelation/show.html.twig', array(
            'tableRelation' => $tableRelation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TableRelations entity.
     *
     * @Route("/{id}/edit", name="/common/tablerelations_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TableRelations $tableRelation)
    {
        $deleteForm = $this->createDeleteForm($tableRelation);
        $editForm = $this->createForm('SysTech\TestTaskBundle\Form\Common\TableRelationsType', $tableRelation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager('commonDb');
            $em->persist($tableRelation);
            $em->flush();

            return $this->redirectToRoute('/common/tablerelations_edit', array('id' => $tableRelation->getId()));
        }

        return $this->render('BaseSynchronizeBundle:Common:TableRelation/edit.html.twig', array(
            'tableRelation' => $tableRelation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TableRelations entity.
     *
     * @Route("/{id}", name="/common/tablerelations_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TableRelations $tableRelation)
    {
        $form = $this->createDeleteForm($tableRelation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager('commonDb');
            $em->remove($tableRelation);
            $em->flush();
        }

        return $this->redirectToRoute('/common/tablerelations_index');
    }

    /**
     * Creates a form to delete a TableRelations entity.
     *
     * @param TableRelations $tableRelation The TableRelations entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TableRelations $tableRelation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('/common/tablerelations_delete', array('id' => $tableRelation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
