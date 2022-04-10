<?php

namespace App\Domain\Owner;

use App\Domain\Shared\Uuid;

class OwnerCreator
{
    public function __construct(
        private OwnerRepository $ownerRepository
    ) {
    }

    public function __invoke(Uuid $uuid, Dni $dni, string $surname, string $name): void
    {
        $owner = Owner::create(uuid: $uuid, dni: $dni, surname: $surname, name: $name);

        $this->ownerRepository->save(owner: $owner);
    }
}
