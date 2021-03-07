<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
  
  


   /**
    * @route("/", name="home")
    *@param PropertyRepository $repository
    * @return Response
    */

    public function index(PropertyRepository  $repository): Response
    {
         $propertie=$repository-> findLatest();
         return  $this->render('Pages/home.html.twig', [
                   'propertie' => $propertie
         ]
     );
    }
}
