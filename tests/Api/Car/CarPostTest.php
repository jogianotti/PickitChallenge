<?php

namespace App\Tests\Api\Car;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CarPostTest extends WebTestCase
{
    public function testItShouldPostCar(): void
    {
        $client = static::createClient();
        $client->request(
            method: 'POST',
            uri: '/cars'
        );

        self::assertResponseIsSuccessful();
    }
}
