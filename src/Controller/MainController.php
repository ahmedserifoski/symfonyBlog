<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
  //This is an annotation
  /**
   * @Route("/", name="home")
   */
  public function index(): Response
  {
    return $this->render("home/index.html.twig");
  }

  /**
   * @Route("/custom/{name?}", name="custom")
   * @param Request $request
   * return Response
   */
  public function custom(Request $request): Response
  {
    // dump($request);
    $name = $request->get('name');
    return $this->render('home/custom.html.twig', [
      'name' => $name
    ]);
  }

  /**
   * @Route("/moreCustom/{name?}", name="moreCustom")
   * @param Request $request
   * @return Response
   */
  public function moreCustom(Request $request): Response {

    $myName = $request->get('name');
    
    $number = random_int(0, 100);

    return $this->render('home/moreCustom.html.twig', [
      'number' => $number,
      'name' => $myName
    ]);
  }
}
