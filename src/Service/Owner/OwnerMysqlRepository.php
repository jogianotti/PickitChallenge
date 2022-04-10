<?php

namespace App\Service\Owner;

use App\Domain\Owner\Owner;
use App\Domain\Owner\OwnerRepository;

class OwnerMysqlRepository implements OwnerRepository
{
    public function save(Owner $owner): void
    {
        // TODO: Implement save() method.
    }
}