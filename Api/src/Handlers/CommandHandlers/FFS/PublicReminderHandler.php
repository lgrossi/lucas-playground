<?php declare(strict_types=1);

namespace Api\Handlers\CommandHandlers\FFS;

use Api\Handlers\CommandHandlers\AbstractCommandHandler;
use Api\Handlers\CommandHandlers\FFS\Traits\TeamFinancialServicesTrait;
use Api\Handlers\CommandHandlers\FFS\Traits\WeekdaysOnlyTrait;

class PublicReminderHandler extends AbstractCommandHandler
{
    use TeamFinancialServicesTrait;
    use WeekdaysOnlyTrait;

    final protected function buildResponse(): string
    {
        $message = "Morning all, just a quick reminder:";
        $message .= "\n\n*Simple questions:* please ask in the channel.";
        $message .= "\n*Questions that will likely require active checking and time:* use :blue-lightning: to report an issue";
        $message .= "\n\nThank you and have a great day!";

        return $message;
    }

    protected function getChannelId(): string
    {
        /* fin-services-public */
        return "C9JJSRXLY";
    }
}
