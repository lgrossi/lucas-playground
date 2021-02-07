<?php declare(strict_types=1);

namespace HelloWorld\Handlers\EventHandlers;

use HelloWorld\Handlers\AbstractHandler;

class VerificationHandler extends AbstractHandler
{
    public const URL_VERIFICATION = "url_verification";

    final public function __construct(protected Object $event) {}

    public function handle(): void
    {
        $this->reply(sprintf('{"challenge": "%s"}', $this->event->challenge));
    }
}
