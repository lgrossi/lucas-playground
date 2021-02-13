<?php declare(strict_types=1);

namespace Api\Handlers\CommandHandlers;

use Api\Clients\CloudFunctionClient;
use Api\Clients\GoogleSheetsClient;
use Api\Handlers\AbstractHandler;

abstract class AbstractCommandHandler extends AbstractHandler
{
    final public function __construct(protected Object $params) {}

    public function handle(): void
    {
        if (!$this->validate()) {
            return;
        }

        $message = $this->buildResponse();

        if ($this->params->notify === true && $this->getChannelId()) {
            error_log($this->getChannelId());
            CloudFunctionClient::sendSlackMessage($message, $this->getChannelId());
        }

        $this->reply($message);
    }

    abstract protected function validate(): bool;

    abstract protected function buildResponse(): string;

    abstract protected function getChannelId(): string;
}
