<?php

namespace SysTech\TestTaskBundle\Controller\Db1;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use SysTech\TestTaskBundle\Entity\Db1\Owner;
use SysTech\TestTaskBundle\Form\Db1\OwnerType;

/**
 * Owner controller.
 *
 * @Route("/db1/owner")
 */
class OwnerController extends Controller
{
    /**
     * Lists all Owner entities.
     *
     * @Route("/", name="/db1/owner_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager('db1');

        $owners = $em->getRepository('BaseSynchronizeBundle:Owner')->findAll();

        return $this->render('BaseSynchronizeBundle:Db1:Owner/index.html.twig', array(
            'owners' => $owners,
        ));
    }

    /**
     * Creates a new Owner entity.
     *
     * @Route("/new", name="/db1/owner_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $owner = new Owner();
        $form = $this->createForm('SysTech\TestTaskBundle\Form\Db1\OwnerType', $owner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager('db1');
            $owner->setCreatedAt(time());
            $owner->setModifiedAt(time());
            $em->persist($owner);
            $em->flush();

            return $this->redirectToRoute('/db1/owner_show', array('id' => $owner->getId()));
        }

        return $this->render('BaseSynchronizeBundle:Db1:Owner/new.html.twig', array(
            'owner' => $owner,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Owner entity.
     *
     * @Route("/{id}", name="/db1/owner_show")
     * @Method("GET")
     */
    public function showAction(Owner $owner)
    {
        $deleteForm = $this->createDeleteForm($owner);

        return $this->render('BaseSynchronizeBundle:Db1:Owner/show.html.twig', array(
            'owner' => $owner,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Owner entity.
     *
     * @Route("/{id}/edit", name="/db1/owner_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Owner $owner)
    {
        $deleteForm = $this->createDeleteForm($owner);
        $editForm = $this->createForm('SysTech\TestTaskBundle\Form\Db1\OwnerType', $owner);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager('db1');
            $owner->setModifiedAt(time());
            $em->persist($owner);
            $em->flush();

            return $this->redirectToRoute('/db1/owner_edit', array('id' => $owner->getId()));
        }

        return $this->render('BaseSynchronizeBundle:Db1:Owner/edit.html.twig', array(
            'owner' => $owner,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Owner entity.
     *
     * @Route("/{id}", name="/db1/owner_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Owner $owner)
    {
        $form = $this->createDeleteForm($owner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager('db1');
            $em->remove($owner);
            $em->flush();
        }

        return $this->redirectToRoute('/db1/owner_index');
    }

    /**
     * Creates a form to delete a Owner entity.
     *
     * @param Owner $owner The Owner entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Owner $owner)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('/db1/owner_delete', array('id' => $owner->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
