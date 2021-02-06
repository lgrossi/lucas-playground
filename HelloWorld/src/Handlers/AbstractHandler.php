<?php declare(strict_types=1);

namespace HelloWorld\Handlers;

use Parable\Http\Response;
use Parable\Http\ResponseDispatcher;

class AbstractHandler implements HandlerInterface
{
    public function __construct(protected Object $event) {}

    public function handle(): void
    {
        $this->reply('{}');
    }

    protected function reply(string $responseBody): void
    {
        $dispatcher = new ResponseDispatcher();
        $dispatcher->dispatch(
            new Response(
                200,
                $responseBody,
                'application/json'
            )
        );
    }
}
