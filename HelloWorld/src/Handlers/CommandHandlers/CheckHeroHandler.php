<?php declare(strict_types=1);

namespace HelloWorld\Handlers\CommandHandlers;

use HelloWorld\Clients\CloudFunctionClient;
use HelloWorld\Handlers\AbstractHandler;

class CheckHeroHandler extends AbstractHandler
{
    public function handle(): void
    {
        $this->reply(CloudFunctionClient::requestHeroCheck(""));
    }
}
