<?php

namespace App\Tests\Api\Car;

use App\Domain\Car\CarSerializer;
use App\Tests\Domain\Car\CarMother;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CarPostTest extends WebTestCase
{
    public function testItShouldPostCar(): void
    {
        $car = CarMother::create();
        $content = CarSerializer::toJson($car);

        $client = static::createClient();
        $client->request(
            method: 'POST',
            uri: '/cars',
            content: $content
        );

        self::assertResponseIsSuccessful();
    }

    public function testItShouldReturnUuidError(): void
    {
        $car = CarMother::create();
        $content = CarSerializer::toJsonWithWrongUuid($car);

        $client = static::createClient();
        $client->request(
            method: 'POST',
            uri: '/cars',
            content: $content
        );

        self::assertResponseStatusCodeSame(expectedCode: 400);
        self::assertEquals(
            expected: '{"code":400,"message":"Invalid UUID"}',
            actual: $client->getResponse()->getContent()
        );
    }

    public function testItShouldReturnPatentError(): void
    {
        $car = CarMother::create();
        $content = CarSerializer::toJsonWithWrongPatent($car);

        $client = static::createClient();
        $client->request(
            method: 'POST',
            uri: '/cars',
            content: $content
        );

        self::assertResponseStatusCodeSame(expectedCode: 400);
        self::assertEquals(
            expected: '{"code":400,"message":"Invalid Patent"}',
            actual: $client->getResponse()->getContent()
        );
    }

    public function testItShouldReturnParametersAreMissingError(): void
    {
        $client = static::createClient();
        $client->request(
            method: 'POST',
            uri: '/cars',
            content: '{}'
        );

        self::assertResponseStatusCodeSame(expectedCode: 400);
        self::assertEquals(
            expected: '{"code":400,"message":"Parameters are missing"}',
            actual: $client->getResponse()->getContent()
        );
    }
}
