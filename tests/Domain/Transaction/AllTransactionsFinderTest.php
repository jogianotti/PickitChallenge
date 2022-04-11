<?php

namespace App\Tests\Domain\Transaction;

use App\Domain\Transaction\AllTransactionsFinder;
use App\Domain\Transaction\TransactionRepository;
use App\Tests\Domain\Car\CarMother;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class AllTransactionsFinderTest extends TestCase
{
    private MockInterface|TransactionRepository $transactionRepository;

    /** @doesNotPerformAssertions */
    public function testItShouldFindAllCarTransactions(): void
    {
        $car = CarMother::create();
        $limit = 10;
        $offset = 0;

        $this->transactionRepository
            ->shouldReceive('all')
            ->with($car, $limit, $offset)
            ->once();

        (new AllTransactionsFinder($this->transactionRepository))($car, $limit, $offset);
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
