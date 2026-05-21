<?php

namespace Kernel\Contracts;

interface ModuleInterface
{
    public function register(): void;

    public function boot(): void;
}
