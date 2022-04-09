<?php

namespace App\Tests\Api\Car;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class AllCarsGetTest extends WebTestCase
{
    public function testItShouldGetAllCars(): void
    {
        $client = static::createClient();
        $client->request(
            method: 'GET',
            uri: '/cars'
        );

        self::assertResponseIsSuccessful();
        self::assertJson($client->getResponse()->getContent());
    }
}