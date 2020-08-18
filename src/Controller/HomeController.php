<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends BaseController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        return $this->redirectToRoute('order_list');
    }
}
