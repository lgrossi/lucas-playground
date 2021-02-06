<?php declare(strict_types=1);

namespace HelloWorld\Handlers;

class EventHandler extends AbstractHandler
{
    public function handle(): void
    {
        $this->reply('"event": true');
    }
}
