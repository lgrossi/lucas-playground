<?php declare(strict_types=1);

namespace HelloWorld\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class CloudFunctionClient
{
    private const HERO_CHECK = "hero-check";
    private const SLACK_MESSAGE = "slack-message";

    /* This needs to be env var. */
    private const CLOUD_FUNCTION_BASE_URI = "https://europe-west3-potent-duality-278504.cloudfunctions.net/slack-notification";

    public static function sendSlackMessage(string $message, string $channelId): void
    {
        (new Client())->postAsync(
            self::CLOUD_FUNCTION_BASE_URI,
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
                self::CLOUD_FUNCTION_BASE_URI,
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
