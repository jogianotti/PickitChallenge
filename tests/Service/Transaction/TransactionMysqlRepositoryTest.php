<?php

namespace App\Tests\Service\Transaction;

use App\Domain\Transaction\Transaction;
use App\Service\Transaction\TransactionMysqlRepository;
use App\Tests\Domain\Transaction\TransactionMother;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TransactionMysqlRepositoryTest extends KernelTestCase
{
    private TransactionMysqlRepository $transactionMysqlRepository;

    public function testItShouldSaveTransaction(): void
    {
        $transaction = TransactionMother::create();

        $this->transactionMysqlRepository->save($transaction);
        $savedTransaction = $this->transactionMysqlRepository->one($transaction->uuid()->value());

        self::assertEquals($transaction, $savedTransaction);
    }

    public function testItShouldRemoveTransaction(): void
    {
        $transaction = TransactionMother::create();

        $this->transactionMysqlRepository->save($transaction);
        $this->transactionMysqlRepository->delete($transaction);
        $deletedTransaction = $this->transactionMysqlRepository->one($transaction->uuid()->value());

        self::assertNull($deletedTransaction);
    }

    public function testItShouldFindAllTransactions(): void
    {
        $this->transactionMysqlRepository->save(TransactionMother::create());
        $this->transactionMysqlRepository->save(TransactionMother::create());
        $this->transactionMysqlRepository->save(TransactionMother::create());
        $this->transactionMysqlRepository->save(TransactionMother::create());

        $transactions = $this->transactionMysqlRepository->all(4, 0);

        self::assertIsArray($transactions);
        self::assertCount(4, $transactions);
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
