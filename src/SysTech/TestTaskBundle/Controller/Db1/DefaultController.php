<?php

namespace SysTech\TestTaskBundle\Controller\Db1;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Employee controller.
 *
 * @Route("/db1")
 */
class DefaultController extends Controller {
    /**
     * @Route("/")
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request) {

        /**
         * @todo: view of list of db1 controllers
         */
        return Response::create('Db1');
    }



}
