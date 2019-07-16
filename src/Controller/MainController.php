<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends Controller
{

    /**
     * @return Response
     * @Route("/", name="home")
     */
    public function main()
    {
        return $this->render("pages/home.html.twig");
    }

}