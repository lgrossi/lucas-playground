<?php declare(strict_types=1);

namespace Api\Handlers\CommandHandlers;

use Api\Handlers\CommandHandlers\Traits\WeekdaysOnlyTrait;

class PublicReminderHandler extends AbstractCommandHandler
{
    use WeekdaysOnlyTrait;

    protected ?string $channelId = "UVBEZQ3JT";

    final protected function buildResponse(): string
    {
        $message = "Morning all, just a quick reminder:";
        $message .= "\n\n*Simple questions:* please ask in the channel.";
        $message .= "\n*Questions that will likely require active checking and time:* use :blue-lightning: to report an issue";
        $message .= "\n\nThank you and have a great day!";

        return $message;
    }
}
