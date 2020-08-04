<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class HomeController extends BaseController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        return $this->redirectToRoute('house_list');
    }
}
