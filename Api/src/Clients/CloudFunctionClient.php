<?php declare(strict_types=1);

namespace Api\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JetBrains\PhpStorm\Pure;

class CloudFunctionClient
{
    public static function sendSlackMessage(string $message, string $channelId, string $teamId): void
    {
        try {
            (new Client())->post(
                self::getUri(),
                [
                    "json" => [
                        "message" => $message,
                        "channel_id" => $channelId,
                        "team_id" => $teamId
                    ]
                ]
            )->getBody()->getContents();
        } catch (GuzzleException $e) {
            error_log($e);
        }
    }

    #[Pure] private static function getUri(): string
    {
        return getenv('CLOUD_FUNCTION_BASE_URI');
    }

}
