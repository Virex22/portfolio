<?php

namespace App\Controller;

use App\Service\AboutService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    /**
     * @Route("/about", name="app_about")
     */
    public function index(AboutService $aboutService): Response
    {
        $viewData = $aboutService->getViewData();
        return $this->render('page/about/about.html.twig', $viewData);
    }
}
