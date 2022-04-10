<?php

namespace App\Domain\Owner;

interface OwnerRepository
{
    public function save(Owner $owner): void;
}