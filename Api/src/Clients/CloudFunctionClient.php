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
        try {
            error_log((new Client())->post(
                self::getUri(),
                [
                    "json" => [
                        "type" => self::SLACK_MESSAGE,
                        "message" => $message,
                        "channel_id" => $channelId
                    ]
                ]
            )->getBody()->getContents());
        } catch (GuzzleException $e) {
            error_log($e);
        }
    }

    #[Pure] private static function getUri(): string
    {
        return getenv('CLOUD_FUNCTION_BASE_URI');
    }

}
