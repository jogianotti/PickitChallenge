<?php

namespace App\Tests\Domain\Transaction;

use App\Domain\Transaction\TransactionCreatedMessage;
use App\Domain\Transaction\TransactionCreator;
use App\Domain\Transaction\TransactionRepository;
use App\Tests\Domain\Car\CarMother;
use Hamcrest\Matchers;
use Mockery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class TransactionCreatorTest extends TestCase
{
    /** @doesNotPerformAssertions */
    public function testItShouldCreateTransaction(): void
    {
        $car = CarMother::create();
        $transaction = TransactionMother::create();
        $transaction->setCar($car);

        $this->transactionRepository
            ->shouldReceive('save')
            ->with(Matchers::equalTo($transaction))
            ->once();

        $message = new TransactionCreatedMessage($transaction->uuid(), $car->uuid());
        $this->messageBus
            ->shouldReceive('dispatch')
            ->with(Matchers::equalTo($message))
            ->once()
            ->andReturn(new Envelope($message));

        (new TransactionCreator($this->transactionRepository, $this->messageBus))(
            $car,
            $transaction->uuid(),
            $transaction->services()
        );
    }

    protected function setUp(): void
    {
        $this->transactionRepository = Mockery::mock(TransactionRepository::class);
        $this->messageBus = Mockery::mock(MessageBusInterface::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }
}
