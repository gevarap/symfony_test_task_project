<?php
/**
 * Created by PhpStorm.
 * User: Gev
 * Date: 15.05.2016
 * Time: 6:26
 */

namespace SysTech\TestTaskBundle\Controller\Common;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Common controller.
 *
 * @Route("/common")
 */
class CommonController extends Controller {

  /**
   * @Route("/", name="/common/relations")
   */
  public function indexAction() {
    /**
     * @todo: view of list of commonDb controllers
     */
    return Response::create('Common commonDb');
  }


}