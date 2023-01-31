<?php

declare(strict_types=1);

namespace App\Messenger;

use Symfony\Component\Messenger\MessageBusInterface;

interface MessageBusAwareInterface
{
    public function setMessageBus(MessageBusInterface $bus): void;

    public function dispatch(object $message): void;
}
