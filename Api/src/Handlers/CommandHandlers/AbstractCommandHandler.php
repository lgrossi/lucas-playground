<?php declare(strict_types=1);

namespace Api\Handlers\CommandHandlers;

use Api\Clients\CloudFunctionClient;
use Api\Clients\GoogleSheetsClient;
use Api\Handlers\AbstractHandler;
use JetBrains\PhpStorm\Pure;

abstract class AbstractCommandHandler extends AbstractHandler
{
    private ?Object $params;

    public function handle(): void
    {
        if (!$this->validate()) {
            return;
        }

        $message = $this->buildResponse();

        if ($this->getProperty("notify") === true) {
            CloudFunctionClient::sendSlackMessage(
                $message,
                $this->getChannelId(),
                $this->getTeamId()
            );
        }

        $this->reply($message);
    }

    public function setParams(?Object $params): void
    {
        $this->params = $params;
    }

    #[Pure] protected function getProperty(string $property)
    {
        if (!$this->params || !property_exists($this->params, $property)) {
            return null;
        }
        return $this->params->{$property};
    }

    abstract protected function validate(): bool;

    abstract protected function buildResponse(): string;

    abstract protected function getChannelId(): string;

    abstract protected function getTeamId(): string;
}
