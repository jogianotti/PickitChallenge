<?php

namespace App\Tests\Api\Car;

use App\Tests\Domain\Car\CarMother;
use App\Tests\Domain\Car\CarSerializer;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CarPutTest extends WebTestCase
{
    public function testItShouldUpdateACar(): void
    {
        $client = static::createClient();
        $car = CarMother::create();

        $content = CarSerializer::toJson($car);
        $client->request(
            method: 'POST',
            uri: '/cars',
            content: $content
        );
        self::assertResponseIsSuccessful();

        $car->setModel('NewModel');
        $car->setBrand('NewBrand');

        $content = CarSerializer::toJson($car);
        $client->request(
            method: 'PUT',
            uri: sprintf('/cars/%s', $car->uuid()->value()),
            content: $content
        );
        self::assertResponseIsSuccessful();

        $client->request(
            method: 'GET',
            uri: sprintf('/cars/%s', $car->uuid()->value()),
        );
        self::assertResponseIsSuccessful();
        self::assertJson($client->getResponse()->getContent());

        $response = json_decode($client->getResponse()->getContent(), associative: true);
        
        self::assertEquals($car->brand(), $response['brand']);
        self::assertEquals($car->model(), $response['model']);
    }
}