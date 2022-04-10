<?php

namespace App\Controller\Car;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AllCarsGetController extends AbstractController
{
    #[Route('/cars', name: 'app_cars_get', methods: ['GET'])]
    public function index(): Response
    {
        return new JsonResponse([]);
    }
}
