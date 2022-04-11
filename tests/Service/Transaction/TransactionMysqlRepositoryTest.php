<?php

namespace App\Tests\Service\Transaction;

use App\Domain\Transaction\Transaction;
use App\Service\Transaction\TransactionMysqlRepository;
use App\Tests\Domain\Car\CarMother;
use App\Tests\Domain\Transaction\TransactionMother;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TransactionMysqlRepositoryTest extends KernelTestCase
{
    private TransactionMysqlRepository $transactionMysqlRepository;

    public function testItShouldSaveTransaction(): void
    {
        $car = CarMother::create();
        $transaction = TransactionMother::create();
        $transaction->setCar($car);

        $this->transactionMysqlRepository->save($transaction);
        $savedTransaction = $this->transactionMysqlRepository->one($car, $transaction->uuid()->value());

        self::assertEquals($transaction, $savedTransaction);
    }

    public function testItShouldRemoveTransaction(): void
    {
        $car = CarMother::create();
        $transaction = TransactionMother::create();
        $transaction->setCar($car);

        $this->transactionMysqlRepository->save($transaction);
        $this->transactionMysqlRepository->delete($transaction);
        $deletedTransaction = $this->transactionMysqlRepository->one($car, $transaction->uuid()->value());

        self::assertNull($deletedTransaction);
    }

    public function testItShouldFindAllTransactions(): void
    {
        $car = CarMother::create();
        $count = random_int(min: 1, max: 10);

        for ($i = 0; $i < $count; $i++) {
            $transaction = TransactionMother::create();
            $transaction->setCar($car);
            $this->transactionMysqlRepository->save($transaction);
        }

        $transactions = $this->transactionMysqlRepository->all($car, limit: $count, offset: 0);

        self::assertIsArray($transactions);
        self::assertCount($count, $transactions);
        self::assertInstanceOf(Transaction::class, current($transactions));
    }

    protected function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        /** @var ManagerRegistry $manager */
        $manager = $container->get(ManagerRegistry::class);
        $this->transactionMysqlRepository = new TransactionMysqlRepository($manager);
    }
}
