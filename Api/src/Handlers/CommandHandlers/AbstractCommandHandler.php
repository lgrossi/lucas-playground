<?php declare(strict_types=1);

namespace Api\Handlers\CommandHandlers;

use Api\Clients\CloudFunctionClient;
use Api\Clients\GoogleSheetsClient;
use Api\Handlers\AbstractHandler;

abstract class AbstractCommandHandler extends AbstractHandler
{
    final public function __construct(protected Object $params) {}

    protected ?string $channelId = null;

    public function handle(): void
    {
        if (!$this->validate()) {
            return;
        }

        $message = $this->buildResponse();

        if ($this->params->notify === true && $this->channelId) {
            error_log($this->channelId);
            CloudFunctionClient::sendSlackMessage($message, $this->channelId);
        }

        $this->reply($message);
    }

    abstract protected function validate(): bool;

    abstract protected function buildResponse(): string;
}
