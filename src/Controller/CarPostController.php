<?php

namespace App\Controller;

use App\Domain\Car\Patent;
use App\Domain\Shared\InvalidArgumentException;
use App\Domain\Shared\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarPostController extends AbstractController
{
    #[Route('/cars', name: 'app_cars_post', methods: ['POST'])]
    public function index(Request $request): Response
    {
        $data = $request->toArray();

        try {
            $uuid = new Uuid($data['uuid']);
            $patent = new Patent($data['patent']);
        } catch (InvalidArgumentException $exception) {
            return new JsonResponse(
                data: [
                    "code" => Response::HTTP_BAD_REQUEST,
                    "message" => $exception->getMessage(),
                ],
                status: Response::HTTP_BAD_REQUEST
            );
        }

        return new Response(status: Response::HTTP_OK);
    }
}
