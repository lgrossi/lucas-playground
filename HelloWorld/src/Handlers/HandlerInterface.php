<?php declare(strict_types=1);

namespace HelloWorld\Handlers;

interface HandlerInterface
{
    public function __construct(Object $event);

    public function handle(): void;
}
