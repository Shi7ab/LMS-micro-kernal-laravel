<?php
namespace Kernel\Contracts;

interface EventBusInterface
{
    public function emit(string $event, array $payload = []): void;

    public function listen(string $event, callable|array $listener): void;
}
