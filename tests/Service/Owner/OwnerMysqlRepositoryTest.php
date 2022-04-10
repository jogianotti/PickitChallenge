<?php

namespace App\Tests\Service\Owner;

use App\Domain\Owner\Owner;
use App\Service\Owner\OwnerMysqlRepository;
use App\Tests\Domain\Owner\OwnerMother;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OwnerMysqlRepositoryTest extends KernelTestCase
{
    private OwnerMysqlRepository $ownerMysqlRepository;

    public function testItShouldSaveAnOwner(): void
    {
        $owner = OwnerMother::create();

        $this->ownerMysqlRepository->save($owner);
        $savedOwner = $this->ownerMysqlRepository->one($owner->uuid()->value());

        self::assertEquals($owner, $savedOwner);
    }

    public function testItShouldRemoveAnOwner(): void
    {
        $owner = OwnerMother::create();

        $this->ownerMysqlRepository->save($owner);
        $this->ownerMysqlRepository->delete($owner);
        $deletedOwner = $this->ownerMysqlRepository->one($owner->uuid()->value());

        self::assertNull($deletedOwner);
    }

    public function testItShouldFindAllOwners(): void
    {
        $this->ownerMysqlRepository->save(OwnerMother::create());
        $this->ownerMysqlRepository->save(OwnerMother::create());
        $this->ownerMysqlRepository->save(OwnerMother::create());

        $owners = $this->ownerMysqlRepository->all(3, 0);

        self::assertIsArray($owners);
        self::assertCount(3, $owners);
        self::assertInstanceOf(Owner::class, current($owners));
    }

    protected function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        /** @var ManagerRegistry $manager */
        $manager = $container->get(ManagerRegistry::class);
        $this->ownerMysqlRepository = new OwnerMysqlRepository($manager);
    }
}
