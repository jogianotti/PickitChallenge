<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarPostController extends AbstractController
{
    #[Route('/cars', name: 'app_cars_post', methods: ['POST'])]
    public function index(): Response
    {
        return new Response(status: Response::HTTP_OK);
    }
}
