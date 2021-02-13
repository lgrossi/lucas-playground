<?php declare(strict_types=1);

namespace Api\Handlers\CommandHandlers;

use Api\Clients\CloudFunctionClient;
use Api\Handlers\AbstractHandler;

class CheckHeroHandler extends AbstractHandler
{
    public function handle(): void
    {
        $this->reply(CloudFunctionClient::requestHeroCheck(""));
    }
}
