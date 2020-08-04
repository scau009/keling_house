<?php


namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HouseController
 * @package App\Controller
 * @Route(path="/houses")
 */
class HouseController extends BaseController
{
    /**
     * @Route(path="/list",name="house_list")
     * @Template(template="house/index.html.twig")
     */
    public function index()
    {

    }
}