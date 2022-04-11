<?php

namespace App\Domain\Shared;

interface StatusMessage
{
    public function status(): string;
}
