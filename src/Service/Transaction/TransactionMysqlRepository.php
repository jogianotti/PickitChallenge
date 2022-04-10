<?php

namespace App\Service\Transaction;

use App\Domain\Transaction\Transaction;
use App\Domain\Transaction\TransactionRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Transaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transaction[]    findAll()
 * @method Transaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionMysqlRepository extends ServiceEntityRepository implements TransactionRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    public function save(Transaction $transaction): void
    {
        $this->_em->persist($transaction);
        $this->_em->flush();
    }

    public function all(int $limit, int $offset): array
    {
        return $this->findBy(criteria: [], limit: $limit, offset: $offset);
    }

    public function one(string $id): ?Transaction
    {
        return $this->find(id: $id);
    }

    public function delete(Transaction $transaction): void
    {
        $this->_em->remove($transaction);
        $this->_em->flush();
    }
}
