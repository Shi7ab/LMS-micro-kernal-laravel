<?php

namespace Kernel\EventBus;

use Illuminate\Support\Facades\Event;
use Kernel\Contracts\EventBusInterface;

class EventBus implements EventBusInterface
{
    public function emit(string $event, array $payload = []): void
    {
        Event::dispatch($event, $payload);
    }

    public function listen(string $event, callable|array $listener): void
    {
        Event::listen($event, $listener);
    }
}
