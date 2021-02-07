<?php declare(strict_types=1);

namespace HelloWorld\Handlers\EventHandlers;

use HelloWorld\Handlers\AbstractHandler;
use JetBrains\PhpStorm\Pure;

class SlackEventHandlerFactory
{
    #[Pure] public static function getSlackEventHandler(Object $event): AbstractHandler
    {
        if (self::isChallenge($event)) {
            return new VerificationHandler($event);
        }

        if (self::isEventCallback($event)) {
            return new EventCallbackHandler($event);
        }

        return new AbstractHandler();
    }

    #[Pure] private static function isSlackEvent(Object $event): bool
    {
        return $event
            && property_exists($event, "type");
    }

    #[Pure] private static function isValidSlackEvent(Object $event): bool
    {
        return self::isSlackEvent($event)
            && in_array($event->type, [VerificationHandler::URL_VERIFICATION, EventCallbackHandler::EVENT_CALLBACK]);
    }

    #[Pure] private static function isEventCallback(Object $event): bool
    {
        return self::isValidSlackEvent($event)
            && property_exists($event, "event")
            && property_exists($event->event, "type");
    }

    #[Pure] private static function isChallenge(Object $event): bool
    {
        return self::isSlackEvent($event)
            && $event->type === VerificationHandler::URL_VERIFICATION
            && property_exists($event, "challenge");
    }
}
