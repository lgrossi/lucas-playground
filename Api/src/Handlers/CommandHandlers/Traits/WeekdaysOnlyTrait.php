<?php declare(strict_types=1);

namespace Api\Handlers\CommandHandlers\Traits;

trait WeekdaysOnlyTrait
{
    final protected function validate(): bool
    {
        if (date('N') > 5) {
            $this->reply("Heroes don't work on weekends baby!");
            return false;
        }
        return true;
    }
}
