<?php

namespace App\Tests\Service\Car;

use App\Domain\Car\Car;
use App\Service\Car\CarMysqlRepository;
use App\Tests\Domain\Car\CarMother;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CarMysqlRepositoryTest extends KernelTestCase
{
    private CarMysqlRepository $carMysqlRepository;

    public function testItShouldSaveACar(): void
    {
        $car = CarMother::create();

        $this->carMysqlRepository->save($car);
        $savedCar = $this->carMysqlRepository->one($car->uuid()->value());

        self::assertEquals($car, $savedCar);
    }

    public function testItShouldRemoveACar(): void
    {
        $car = CarMother::create();

        $this->carMysqlRepository->save($car);
        $this->carMysqlRepository->delete($car);
        $deletedCar = $this->carMysqlRepository->one($car->uuid()->value());

        self::assertNull($deletedCar);
    }

    public function testItShouldFindAllCars(): void
    {
        $this->carMysqlRepository->save(CarMother::create());
        $this->carMysqlRepository->save(CarMother::create());
        $this->carMysqlRepository->save(CarMother::create());

        $cars = $this->carMysqlRepository->all(3, 0);

        self::assertIsArray($cars);
        self::assertCount(3, $cars);
        self::assertInstanceOf(Car::class, current($cars));
    }

    protected function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        /** @var ManagerRegistry $manager */
        $manager = $container->get(ManagerRegistry::class);
        $this->carMysqlRepository = new CarMysqlRepository($manager);
    }
}
