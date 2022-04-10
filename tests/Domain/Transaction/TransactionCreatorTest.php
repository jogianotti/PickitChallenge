<?php

namespace App\Tests\Domain\Transaction;

use App\Domain\Transaction\TransactionCreator;
use App\Domain\Transaction\TransactionRepository;
use App\Tests\Domain\Car\CarMother;
use Hamcrest\Matchers;
use Mockery;
use PHPUnit\Framework\TestCase;

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

        (new TransactionCreator($this->transactionRepository))(
            $car,
            $transaction->uuid(),
            $transaction->services()
        );
    }

    protected function setUp(): void
    {
        $this->transactionRepository = Mockery::mock(TransactionRepository::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }
}
