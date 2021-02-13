<?php declare(strict_types=1);

namespace Api\Handlers\CommandHandlers\FFS\Traits;

use JetBrains\PhpStorm\Pure;

trait WeekdaysOnlyTrait
{
    #[Pure] final protected function validate(): bool
    {
        if (date('N') > 5) {
            $this->reply("Heroes don't work on weekends baby!");
            return false;
        }
        return true;
    }
}
