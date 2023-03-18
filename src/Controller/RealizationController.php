<?php

namespace App\Controller;

use App\Service\RealizationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RealizationController extends AbstractController
{
    /**
     * @Route("/realization", name="app_realization")
     */
    public function index(RealizationService $realizationService): Response
    {
        $viewData = $realizationService->getViewData();
        return $this->render('page/realization/realization.html.twig', $viewData);
    }
}
