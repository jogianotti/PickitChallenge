<?php

namespace App\Api\Car;

use App\Domain\Car\AllCarsFinder;
use App\Tests\Domain\Car\CarSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AllCarsGetController extends AbstractController
{
    #[Route('/cars', name: 'app_cars_get', methods: ['GET'])]
    public function index(Request $request, AllCarsFinder $allCarsFinder): Response
    {
        $limit = $request->get('limit', 10);
        $offset = $request->get('offset', 0);

        $cars = $allCarsFinder($limit, $offset);

        return new JsonResponse(CarSerializer::arrayToJson($cars));
    }
}
