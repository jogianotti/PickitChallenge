<?php

namespace App\Tests\Api\Car;

use App\Domain\Car\CarSerializer;
use App\Domain\Owner\OwnerSerializer;
use App\Tests\Domain\Car\CarMother;
use App\Tests\Domain\Owner\OwnerMother;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CarOwnerPutTest extends WebTestCase
{
    public function testItShouldSetCarOwner(): void
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

        $owner = OwnerMother::create();
        $content = OwnerSerializer::toJson($owner);
        $client->request(
            method: 'POST',
            uri: '/owners',
            content: $content
        );
        self::assertResponseIsSuccessful();

        $client->request(
            method: 'PUT',
            uri: sprintf('/cars/%s/owner/%s', $car->uuid()->value(), $owner->uuid()->value()),
        );
        self::assertResponseIsSuccessful();
    }
}