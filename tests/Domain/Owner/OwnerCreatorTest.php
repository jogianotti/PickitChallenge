<?php

namespace App\Tests\Domain\Owner;

use App\Domain\Owner\Dni;
use App\Domain\Owner\Owner;
use App\Domain\Owner\OwnerCreatedMessage;
use App\Domain\Owner\OwnerCreator;
use App\Domain\Owner\OwnerRepository;
use App\Domain\Shared\Uuid;
use Hamcrest\Matchers;
use Mockery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class OwnerCreatorTest extends TestCase
{
    /** @doesNotPerformAssertions */
    public function testItShouldCreateAnOwner(): void
    {
        $uuid = new Uuid('aa6ed393-e85e-4bb0-b706-a9899268e0c6');
        $dni = new Dni('23456789');
        $surname = 'Gomez';
        $name = 'Estela';

        $owner = Owner::create(
            uuid: $uuid,
            dni: $dni,
            surname: $surname,
            name: $name
        );

        $this->ownerRepository
            ->shouldReceive('save')
            ->with(Matchers::equalTo($owner))
            ->once();

        $message = new OwnerCreatedMessage($uuid);
        $this->messageBus
            ->shouldReceive('dispatch')
            ->with(Matchers::equalTo($message))
            ->once()
            ->andReturn(new Envelope($message));

        (new OwnerCreator($this->ownerRepository, $this->messageBus))($uuid, $dni, $surname, $name);
    }

    protected function setUp(): void
    {
        $this->ownerRepository = Mockery::mock(OwnerRepository::class);
        $this->messageBus = Mockery::mock(MessageBusInterface::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }
}
