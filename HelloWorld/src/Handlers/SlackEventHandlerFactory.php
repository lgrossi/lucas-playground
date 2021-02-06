<?php declare(strict_types=1);

namespace HelloWorld\Handlers;

use JetBrains\PhpStorm\Pure;

class SlackEventHandlerFactory
{
    protected const PAYLOAD_EVENT_CALLBACK = "event_callback";
    protected const PAYLOAD_URL_VERIFICATION = "url_verification";

    /** @var string[] */
    protected static array $allowedEventTypes = [
        "message",
        "workflow_step_execute"
    ];

    #[Pure] public static function getSlackEventHandler(Object $event): AbstractHandler
    {
        if (self::hasVerificationPayload($event)) {
            return new VerificationHandler($event);
        }

        if (self::hasEventPayload($event)) {
            return new EventHandler($event);
        }

        return new AbstractHandler($event);
    }

    #[Pure] private static function isSlackEvent(Object $event): bool
    {
        return $event
            && property_exists($event, "type");
    }

    #[Pure] private static function isValidSlackEvent(Object $event): bool
    {
        return self::isSlackEvent($event)
            && in_array($event->type, [self::PAYLOAD_EVENT_CALLBACK, self::PAYLOAD_URL_VERIFICATION]);
    }

    #[Pure] private static function hasEventPayload(Object $event): bool
    {
        return self::isValidSlackEvent($event)
            && property_exists($event, "event")
            && property_exists($event->event, "type")
            && in_array($event->event->type, self::$allowedEventTypes);
    }

    #[Pure] private static function hasVerificationPayload(Object $event): bool
    {
        return self::isSlackEvent($event)
            && $event->type === self::PAYLOAD_URL_VERIFICATION
            && property_exists($event, "challenge");
    }

    #[Pure] private static function getEventPayload(Object $event): ?string
    {
        return self::hasEventPayload($event) ? $event->event : null;
    }
}
