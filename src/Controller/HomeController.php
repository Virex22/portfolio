<?php

namespace App\Controller;

use App\Helper\ConfigurationHelper;
use App\Repository\ServiceRepository;
use App\Service\HomeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(HomeService $homeService): Response
    {
        $viewData = $homeService->getViewData();
        return $this->render('page/home/home.html.twig', $viewData);
    }
}
