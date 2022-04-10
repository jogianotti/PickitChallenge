<?php

namespace App\Service\Car;

use App\Domain\Car\Car;
use App\Domain\Car\CarRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Car|null find($id, $lockMode = null, $lockVersion = null)
 * @method Car|null findOneBy(array $criteria, array $orderBy = null)
 * @method Car[]    findAll()
 * @method Car[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarMysqlRepository extends ServiceEntityRepository implements CarRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

    public function save(Car $car): void
    {
        $this->_em->persist($car);
        $this->_em->flush();
    }

    public function all(int $limit, int $offset): array
    {
        return $this->findBy(criteria: [], limit: $limit, offset: $offset);
    }

    public function one(string $id): ?Car
    {
        return $this->find(id: $id);
    }

    public function delete(Car $car): void
    {
        $this->_em->remove($car);
        $this->_em->flush();
    }
}
