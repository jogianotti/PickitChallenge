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
            $this->validateData($data);
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

    /**
     * @throws InvalidArgumentException
     */
    private function validateData(array $data): void
    {
        $parametersExists = isset(
            $data['uuid'],
            $data['brand'],
            $data['model'],
            $data['year'],
            $data['patent'],
            $data['color']
        );

        $parametersHasContent = !empty($data['uuid'])
            && !empty($data['brand'])
            && !empty($data['model'])
            && !empty($data['year'])
            && !empty($data['patent'])
            && !empty($data['color']);

        if (!$parametersExists || !$parametersHasContent) {
            throw new InvalidArgumentException('Parameters are missing');
        }
    }
}
