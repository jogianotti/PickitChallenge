<?php

namespace App\Service\Shared;

use App\Domain\Shared\StatusMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class StatusMessageHandler
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function __invoke(StatusMessage $message)
    {
        $this->logger->info($message->status());
    }
}
