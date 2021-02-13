<?php declare(strict_types=1);

namespace Api\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JetBrains\PhpStorm\Pure;

class CloudFunctionClient
{
    private const SLACK_MESSAGE = "slack-message";

    public static function sendSlackMessage(string $message, string $channelId): void
    {
        (new Client())->postAsync(
            self::getUri(),
            [
                "json" => [
                    "type" => self::SLACK_MESSAGE,
                    "message" => $message,
                    "channel_id" => $channelId
                ]
            ]
        );
    }

    #[Pure] private static function getUri(): string
    {
        return getenv('CLOUD_FUNCTION_BASE_URI');
    }

}
