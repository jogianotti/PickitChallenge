<?php

namespace App\Service\Owner;

use App\Domain\Owner\Owner;
use App\Domain\Owner\OwnerRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Owner|null find($id, $lockMode = null, $lockVersion = null)
 * @method Owner|null findOneBy(array $criteria, array $orderBy = null)
 * @method Owner[]    findAll()
 * @method Owner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OwnerMysqlRepository extends ServiceEntityRepository implements OwnerRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Owner::class);
    }

    public function save(Owner $owner): void
    {
        $this->_em->persist($owner);
        $this->_em->flush();
    }

    public function all(int $limit, int $offset): array
    {
        return $this->findBy(criteria: [], limit: $limit, offset: $offset);
    }

    public function one(string $id): ?Owner
    {
        return $this->find(id: $id);
    }

    public function delete(Owner $owner): void
    {
        $this->_em->remove($owner);
        $this->_em->flush();
    }
}
