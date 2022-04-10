<?php

namespace App\Controller\Owner;

use App\Domain\Owner\Dni;
use App\Domain\Owner\OwnerCreator;
use App\Domain\Shared\InvalidArgumentException;
use App\Domain\Shared\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OwnerPostController extends AbstractController
{
    #[Route('/owners', name: 'app_owners_post', methods: ['POST'])]
    public function index(Request $request, OwnerCreator $ownerCreator): Response
    {
        $data = $request->toArray();

        try {
            $this->validateData($data);
            $uuid = new Uuid($data['uuid']);
            $dni = new Dni($data['dni']);

            $ownerCreator(
                uuid: $uuid,
                dni: $dni,
                surname: $data['surname'],
                name: $data['name']
            );
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
            $data['dni'],
            $data['surname'],
            $data['name']
        );

        $parametersHasContent = !empty($data['uuid'])
            && !empty($data['dni'])
            && !empty($data['name'])
            && !empty($data['surname']);

        if (!$parametersExists || !$parametersHasContent) {
            throw new InvalidArgumentException('Parameters are missing');
        }
    }
}
