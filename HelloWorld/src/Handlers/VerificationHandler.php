<?php declare(strict_types=1);

namespace HelloWorld\Handlers;

class VerificationHandler extends AbstractHandler
{
    public function handle(): void
    {
        $this->reply(sprintf('{"challenge": "%s"}', $this->event->challenge));
    }
}
