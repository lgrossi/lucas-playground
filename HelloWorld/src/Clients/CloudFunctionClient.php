<?php declare(strict_types=1);

namespace HelloWorld\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class CloudFunctionClient
{
    private const HERO_CHECK = "hero-check";
    private const SLACK_MESSAGE = "slack-message";

    public static function sendSlackMessage(string $message, string $channelId): void
    {
        (new Client())->postAsync(
            getenv('CLOUD_FUNCTION_BASE_URI'),
            [
                "json" => [
                    "type" => self::SLACK_MESSAGE,
                    "message" => $message,
                    "channel_id" => $channelId
                ]
            ]
        );
    }

    public static function requestHeroCheck(?string $channelId): string
    {
        try {
            return (new Client())->post(
                getenv('CLOUD_FUNCTION_BASE_URI'),
                [
                    "json" => [
                        "type" => self::HERO_CHECK,
                        "channel_id" => $channelId,
                        "silent_response" => true
                    ]
                ]
            )->getBody()->getContents();
        } catch (GuzzleException $e) {
            return $e->getMessage();
        }
    }
}
