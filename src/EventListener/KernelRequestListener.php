<?php

namespace App\EventListener;

use App\Handler\Routage\MaintenanceHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class KernelRequestListener
{
    private $maintenanceHandler;
    private $twig;

    public function __construct(MaintenanceHandler $maintenanceHandler, \Twig\Environment $twig)
    {
        $this->maintenanceHandler = $maintenanceHandler;
        $this->twig = $twig;
    }

    public function onKernelRequest(RequestEvent $event){
        if (!$this->maintenanceHandler->isInMaintenance())
            return;

        $response = new Response($this->twig->render('global/maintenance/maintenance.html.twig'), Response::HTTP_SERVICE_UNAVAILABLE);

        $event->setResponse($response);
        $event->stopPropagation();
    }

}