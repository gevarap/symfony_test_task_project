<?php

namespace SysTech\TestTaskBundle\Controller\Db1;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\VarDumper\VarDumper;
use SysTech\TestTaskBundle\Entity\Db1\Employee;
use SysTech\TestTaskBundle\Form\Db1\EmployeeType;
use SysTech\TestTaskBundle\Entity\Db1\Repository as Repository;

/**
 * Employee controller.
 *
 * @Route("/db1/employee")
 */
class EmployeeController extends Controller
{
    /**
     * Lists all Employee entities.
     *
     * @Route("/", name="/db1/employee_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager('db1');
        $employees = $em->getRepository('BaseSynchronizeBundle:Employee')->findAll();
        return $this->render('BaseSynchronizeBundle:Db1:Employee/index.html.twig', array(
            'employees' => $employees,
        ));
    }

    /**
     * Creates a new Employee entity.
     *
     * @Route("/new", name="/db1/employee_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $employee = new Employee();
        $form = $this->createForm('SysTech\TestTaskBundle\Form\Db1\EmployeeType', $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager('db1');
            $employee->setCreatedAt(time());
            $employee->setModifiedAt(time());
            $em->persist($employee);
            $em->flush();

            return $this->redirectToRoute('/db1/employee_show', array('id' => $employee->getId()));
        }

        return $this->render('BaseSynchronizeBundle:Db1:Employee/new.html.twig', array(
            'employee' => $employee,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Employee entity.
     *
     * @Route("/{id}", name="/db1/employee_show")
     * @Method("GET")
     */
    public function showAction(Employee $employee)
    {
        $deleteForm = $this->createDeleteForm($employee);

        return $this->render('BaseSynchronizeBundle:Db1:employee/show.html.twig', array(
            'employee' => $employee,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Employee entity.
     *
     * @Route("/{id}/edit", name="/db1/employee_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Employee $employee)
    {
        $deleteForm = $this->createDeleteForm($employee);
        $editForm = $this->createForm('SysTech\TestTaskBundle\Form\Db1\EmployeeType', $employee);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager('db1');
            $employee->setModifiedAt(time());
            $em->persist($employee);
            $em->flush();

            return $this->redirectToRoute('/db1/employee_index');
        }

        return $this->render('BaseSynchronizeBundle:Db1:Employee/edit.html.twig', array(
            'employee' => $employee,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Employee entity.
     *
     * @Route("/{id}", name="/db1/employee_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param Employee $employee
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Employee $employee)
    {
        $form = $this->createDeleteForm($employee);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager('db1');
            $em->remove($employee);
            $em->flush();
        }

        return $this->redirectToRoute('/db1/employee_index');
    }

    /**
     * Creates a form to delete a Employee entity.
     *
     * @param Employee $employee The Employee entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Employee $employee)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('/db1/employee_delete', array('id' => $employee->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
